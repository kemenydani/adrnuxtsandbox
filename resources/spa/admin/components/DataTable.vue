<template>
	<v-card class="elevation-3">
		<v-toolbar flat color="white">
			<v-toolbar-title>{{ title }}</v-toolbar-title>
			<v-spacer></v-spacer>
			<!--
			<slot name="toolbar" :selected="selected" :data="items">
			</slot>-->
			<!-- delete prompt -->
			<v-dialog v-model="dialogs.delete.open" persistent max-width="500">
				<v-btn slot="activator" @click="dialogs.delete.open = true" color="red" dark small>Delete</v-btn>
				<v-card>
					<v-card-title class="headline">Delete selected items?</v-card-title>
					<v-card-text>
						<v-list>
							<template v-for="(item, key) in selected" v-if="selected[key]">
								<v-list-tile :key="'tile' + key" dense>
									<v-list-tile-action>
										<v-checkbox v-model="selected[key]" primary hide-details></v-checkbox>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title>{{ item.Title }}</v-list-tile-title>
									</v-list-tile-content>
								</v-list-tile>
								<v-divider v-if="key !== selected.length - 1" :key="'divider' + key"></v-divider>
							</template>
						</v-list>
					</v-card-text>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="primary" flat @click.native="dialogs.delete.open = false">Cancel</v-btn>
						<v-btn color="red" flat :loading="dialogs.delete.loading" @click.native="deleteSelected">Continue</v-btn>
					</v-card-actions>
				</v-card>
			</v-dialog>
			
			<v-dialog v-model="dialogs.edit.open" fullscreen transition="dialog-bottom-transition">
				<v-card>
					<v-toolbar dark color="primary">
						<v-btn icon dark @click.native="dialogs.edit.open = false">
							<v-icon>close</v-icon>
						</v-btn>
						<v-toolbar-title>Settings</v-toolbar-title>
						<v-spacer></v-spacer>
						<v-toolbar-items>
							<v-btn dark flat @click.native="dialogs.edit.open = false">Save</v-btn>
						</v-toolbar-items>
					</v-toolbar>
					<v-list three-line subheader>
		
					</v-list>
					<v-divider></v-divider>
					<v-list three-line subheader>
			
					</v-list>
				</v-card>
			</v-dialog>
			
		</v-toolbar>
		<v-data-table :headers-length="config.colCount" :items="items" :loading="loading" :item-key="itemKey" :pagination.sync="pagination" :total-items="pagination.totalItems" v-model="selected" select-all>
			<!-- headers -->
			<template slot="headers" slot-scope="props">
				<tr>
					<th>
						<v-checkbox :input-value="props.all" :indeterminate="props.indeterminate" @click.native="checkAll" primary hide-details></v-checkbox>
					</th>
					<th :key="header.text"
							:align="header.align ? header.align : 'left'"
							:class="['column', header.sortable ? 'sortable ' + (pagination.descending ? 'desc ' : 'asc') + (pagination.sortBy === header.value ? 'active ' : '') : '']"
							v-for="header in fields"
							@click="() => { header.sortable ? changeSort(header.value) : false; }"
					>
						<v-icon v-if="header.sortable" small>arrow_upward</v-icon>
						{{ header.text }}
					</th>
					<th align="right" class="column" v-if="rowActions"></th>
				</tr>
			</template>
			<!-- rows -->
			<template slot="items" slot-scope="props">
				<tr :active="props.selected" @click="props.selected = !props.selected">
					<td width="80px">
						<v-checkbox :input-value="props.selected" primary hide-details></v-checkbox>
					</td>
					<td v-for="(th, key) in fields"
							v-if="props.item.hasOwnProperty(th.value)"
							v-html="th.hasOwnProperty('filter') ? th.filter(props.item[th.value]) : props.item[th.value]"
							:key="key"
							:width="th.width"
							:align="th.align"
							:class="th.class"
					>
					</td>
					<td class="text-xs-right" v-if="rowActions">
						<v-icon color="orange" @click="dialogs.edit.open = true" small class="mr-2" >edit</v-icon>
					</td>
				</tr>
			</template>
		</v-data-table>
	</v-card>
</template>

<script>
	/* eslint-disable vue/no-side-effects-in-computed-properties */
	
	export default {
		name : 'DataTable',
		props : {
			title : { type : String, required : false, default : () => ''},
			initialItems: { type : Array, required : false, default : () => [] },
			initialPagination : {
				type : Object,
				required : false,
				default : () => ({
					rowsPerPage : 0,
					page : 1,
					totalPages : 0,
					totalItems : 0,
					sortBy : "",
					search : "",
					descending : true
				})
			},
			itemKey : { type : String, required : true },
			rowActions : { type : Boolean, required : false, default : () => true },
			descending : { type : Boolean, required : false, default : () => true },
			config : { type : Object, required : true },
		},
		data : () => ({
			dialogs : {
				delete : {
					open : false,
					loading : false,
				},
				edit : {
					open : false,
					loading : false
				}
			},
			selected : [],
			items : [],
			pagination : {},
			loading : false,
		}),
		methods:
		{
			async onFetchData()
			{
				this.loading = true;
				
				let queryString = Object.keys(this.pagination).map(key => key + '=' + this.pagination[key]).join('&');
				
				const response =  await fetch("/api/articles?" + queryString, {
					credentials: 'include',
					method: 'GET',
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json'
					}
				});
				
				let json = await response.json();
				
				this.items = json.items || [];
				
				Object.keys(json.pagination).forEach(key => this.pagination[key] = json.pagination[key]);
			
				this.loading = false;
				
				return json;
			},
			deleteSelected ()
			{
				this.dialogs.delete.loading = true;
				
				return new Promise((resolve, reject) => {
					setTimeout(() => {
						this.dialogs.delete.loading = false;
						this.dialogs.delete.open = false;
						resolve(true)
					}, 6000)
				})
				
			},
			checkAll ()
			{
				this.selected = this.selected.length ? [] : this.items.slice();
			},
			changeSort (column)
			{
				if (this.pagination.sortBy === column)
				{
					this.pagination.descending = !this.pagination.descending;
				}
				else
				{
					this.pagination.sortBy = column;
					this.pagination.descending = false;
				}
			}
		},
		computed :
		{
			fields ()
			{
				return Object.keys(this.config.fields).map(value => Object.assign(this.config.fields[value], { value }));
			}
		},
		watch:
		{
			pagination:
			{
				handler : function( v )
				{
					this.onFetchData()
				},
				deep: true
			},
			selected :
			{
				handler : function( v )
				{
					this.$emit('select', v);
				},
				deep : true
			},
		},
		created()
		{
			this.items = this.initialItems.length ? this.initialItems : [];
			this.pagination = this.initialPagination;
		},
	}
</script>

<style lang="scss">

</style>