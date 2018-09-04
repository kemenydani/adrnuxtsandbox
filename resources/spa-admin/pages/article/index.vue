<template>
	<v-content>
		<DataTable
				title="Articles"
				:config="config"
				:initial-pagination="data.pagination"
				:initial-items="data.items"
				itemKey="Id"
				:rowActions="true"
				@select="onRowSelect"
		>
			<template slot="toolbar" slot-scope="props">
				
				<v-dialog v-model="dialogs.create.open" persistent max-width="500px" :loading="true">
					<v-btn slot="activator" small color="primary">Create New</v-btn>
					<v-card>
						<v-card-title>
							<span class="headline">New Article</span>
						</v-card-title>
						<v-card-text>
							<v-layout wrap>
								<v-flex xs12>
									<v-text-field
											label="Title"
											hint="Title of the article"
											persistent-hint
											required
									></v-text-field>
								</v-flex>
							</v-layout>
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="blue darken-1" flat :disabled="dialogs.create.loading" @click.native="dialogs.create.open = false">Cancel</v-btn>
							<v-btn
									:loading="dialogs.create.loading"
									@click.native="dialogs.create.loading = true; props.onCreateItem().then( () => { dialogs.create.open = false; dialogs.create.loading = false } )"
									color="blue darken-1"
									flat>
								Save
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</template>
		</DataTable>
	</v-content>
</template>

<script>
	
	export default {
		head: { title : 'Article Overview' },
		data() {
			return {
				dialogs : {
					create : {
						open : false,
						loading : false
					}
				},
				data : {},
				config : {
					colCount : 6,
					headers : [
						{
							text: 'Id',
							align: 'left',
							value: 'Id',
							width: '30px',
							sortable : true
						},
						{
							text: 'Title',
							align: 'left',
							value: 'Title',
							filter : function( v ){
								return '<a href="#">' + v + '</a>';
							},
							sortable : true
						},
						{
							text: 'Active',
							align: 'left',
							value: 'Active',
							filter : function( v ){
								return v === '0' ? 'Inactive' : 'Active';
							},
							sortable : true
						},
						{
							text: 'CreatedAt',
							align: 'right',
							value: 'CreatedAt',
							filter : function( v ){
								return v;
							},
							sortable : true
						},
					],
					fields : {
						Id : {
							text : 'Id',
							hint : 'This is an Id hint',
							width : '30px',
							sortable : true,
						},
						Title : {
							text : 'Title',
							hint : 'This is a Title hint',
							sortable : true,
							edit : 'text',
							filter : function( v ){
								return '<a href="#">' + v + '</a>';
							},
						},
						Active : {
							text : 'Active',
							hint : 'This is an Active hint',
							sortable : true,
							edit : 'switch',
							filter : function( v ){
								return v === '0' ? 'Inactive' : 'Active';
							},
						},
						CreatedAt : {
							text : 'CreatedAt',
							hint : 'This is an CreatedAt hint',
							sortable : true,
							edit : 'datetime',
							filter : function( v ){
								return v;
							},
						},
					},
				},
			}
		},
		async asyncData( context )
		{
			const response =  await fetch("/api/articles", {
				credentials: 'include',
				method: 'GET',
				headers: {
					'Accept': 'application/json',
					'Content-Type': 'application/json'
				}
			});
			
			let d = await response.json();
			
			return { data : d }
		},
		methods :
		{
			onRowSelect(selected = [])
			{
				console.log(selected)
			}
		}
	}
</script>
