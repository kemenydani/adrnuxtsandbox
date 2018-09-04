<template>
	<v-layout row style="display: flex; justify-content: center; align-items: center; align-content: center;" app>
		<v-flex xs12 sm6 md4 lg3 offset-sm>
			<v-card app>
				<v-card-title app>
					<h2>Dashboard Login</h2>
				</v-card-title>
				<v-divider></v-divider>
				<v-card-text>
					<v-container>
						<form @submit.prevent="onSubmit">
							<v-layout row>
								<v-flex xs12>
									<v-text-field
											name="email"
											label="Email"
											id="email"
											v-model="Email"
											type="email"
											required></v-text-field>
								</v-flex>
							</v-layout>
							<v-layout row>
								<v-flex xs12>
									<v-text-field
											name="password"
											label="Password"
											id="password"
											v-model="Password"
											type="password"
											required></v-text-field>
								</v-flex>
							</v-layout>
							<v-layout row>
								<v-flex xs12>
									<v-checkbox
											label="Remember Me"
											v-model="Remember"
									></v-checkbox>
								</v-flex>
							</v-layout>
							<v-layout row>
								<v-flex xs12>
									<v-btn type="submit">
										Sign in
										<span slot="loader" class="custom-loader">
                        <v-icon light>cached</v-icon>
										</span>
									</v-btn>
								</v-flex>
							</v-layout>
						</form>
					</v-container>
				</v-card-text>
			</v-card>
		</v-flex>
	</v-layout>
</template>

<script>
	
	export default {
		layout : 'auth',
		middleware: 'no-auth',
		data() {
			return {
				Email : '',
				Password: '',
				Remember: true
			}
		},
		methods: {
			async onSubmit()
			{
					let response = await this.postCredentials({
						Email    : this.Email,
						Password : this.Password
					});
					
					let userData = await response.json();
					
					if(response.status === 200 && userData)
					{
						//this.$store.dispatch('setIsAuthenticated', true);
						this.$store.dispatch('setAuthUser', userData);
						this.$router.push('/');
					}
			},
			postCredentials( credentials = {} )
			{
				return fetch('api/signin', {
					credentials: 'include',
					method: 'POST',
					headers: {
						'Accept': 'application/json',
						'Content-Type': 'application/json'
					},
					body: JSON.stringify(credentials)
				})
			}
		},
		mounted() {
		
		}
	}
</script>

<style lang="scss">

</style>