<template>
  <v-app>
    <v-navigation-drawer
      :mini-variant="miniVariant"
      :clipped="clipped"
      v-model="drawer"
      fixed
      app
    >
      <v-list>
        <v-list-tile
          router
          :to="item.to"
          :key="i"
          v-for="(item, i) in items"
          exact
        >
          <v-list-tile-action>
            <v-icon v-html="item.icon"></v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title"></v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="primary" :clipped-left="clipped" fixed app dark>
      <v-toolbar-side-icon @click="drawer = !drawer"></v-toolbar-side-icon>
      <!--
      <v-btn icon @click.stop="miniVariant = !miniVariant">
        <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"></v-icon>
      </v-btn>
      -->
      <!--
      <v-btn icon @click.stop="clipped = !clipped">
        <v-icon>web</v-icon>
      </v-btn>
      -->
      <v-toolbar-title v-text="title"></v-toolbar-title>
      <v-spacer></v-spacer>
  
      <v-badge overlap color="red" class="mr-2">
        <span slot="badge" v-if="authUserActiveNotificationSum && authUserActiveNotificationSum > 0">
          {{ authUserActiveNotificationSum }}
        </span>
        <v-icon medium @click.stop="rightDrawer = !rightDrawer"
                large
                color="white"
        >
          account_circle
        </v-icon>
      </v-badge>
    </v-toolbar>
    <v-content>
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-navigation-drawer app :right="right" v-model="rightDrawer" fixed>
      
      <v-list>
        <v-list-tile>
          <v-list-tile-avatar>
            <img>
          </v-list-tile-avatar>
          <v-list-tile-content>
            <v-list-tile-title>{{ authUser.UserName }}</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
              <v-btn fab title="logout" depressed small color="red" @click.stop="onSignOut">
                <v-icon color="white">power_settings_new</v-icon>
              </v-btn>
          </v-list-tile-action>
        </v-list-tile>
      </v-list>
  
      <v-list-tile color="primary">
        <h3>Timeline</h3>
      </v-list-tile>
  
      <v-list dense>
        <template v-for="(item, key) in authUserNotifications">
          <v-divider :key="'divider' + key"></v-divider>
          <v-list-tile :key="'item' + key">
            <!--
            <v-list-tile-avatar>
              <v-icon :color="item.Touched == 1 ? 'grey' : 'accent'">notification_important</v-icon>
            </v-list-tile-avatar>
            -->
            <v-list-tile-content>
              <v-list-tile-sub-title v-if="item.Touched == 1">{{ item.Message }}</v-list-tile-sub-title>
              <v-list-tile-title v-else>{{ item.Message }}</v-list-tile-title>
            </v-list-tile-content>
            <!--
            <v-list-tile-action>
              <v-icon v-if="item.Touched == 0"
                  color="primary"
              >
                check
              </v-icon>
              <v-icon v-else-if="item.Touched == 1"
                      color="grey"
              >
                done_all
              </v-icon>
            </v-list-tile-action>
            -->
          </v-list-tile>
        </template>
   
        <v-list-tile color="primary">
          <v-list-tile-title class="text-xs-right">History »</v-list-tile-title>
        </v-list-tile>
      </v-list>
      
      <v-list-tile color="primary">
        <h3>Inbox</h3>
      </v-list-tile>
      
      <v-list two-line v-if="authUserConversations && authUserConversations.length">
        <template v-for="(item, key) in authUserConversations">
          <v-divider :key="'divider' + key"></v-divider>
          <v-list-tile :key="'item' + key" @click.native="openConversation(key)" avatar ripple>
            <v-list-tile-content>
              <v-list-tile-title>{{ item.LastMessageUser }}</v-list-tile-title>
              <v-list-tile-sub-title>{{ item.LastMessageText }}</v-list-tile-sub-title>
              <v-list-tile-sub-title></v-list-tile-sub-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-icon>
                mail
              </v-icon>
            </v-list-tile-action>
          </v-list-tile>
        </template>
        <v-list-tile color="primary">
          <v-list-tile-title class="text-xs-right">History »</v-list-tile-title>
        </v-list-tile>
      </v-list>

    </v-navigation-drawer>
  </v-app>
</template>

<script>
  export default {
  	name: 'layoutDefault',
	  middleware: 'auth',
    data() {
      return {
        clipped: false,
        drawer: true,
        fixed: false,
        items: [
          { icon: 'apps', title: 'Welcome', to: '/' },
          { icon: 'bubble_chart', title: 'Articles', to: '/article' },
	        { icon: 'group', title: 'Users', to: '/user' }
        ],
        miniVariant: false,
        right: true,
        rightDrawer: false,
        title: 'Dashboard',
        
        services: {
        	notification : {
        		updateInterval : process.env.updateNotificationsInterval
          },
          conversation : {
	          updateInterval : process.env.updateConversationsInterval,
            focusedUpdateInterval : 5000,
            focused : false
          }
        }
      }
    },
	  computed: {
		  isAuthenticated() {
			  return this.$store.getters.getIsAuthenticated;
		  },
		  authUser() {
			  return this.$store.getters.getAuthUser;
		  },
      authUserNotifications(){
	      return this.$store.getters.getAuthUserNotifications;
      },
		  authUserConversations(){
			  return this.$store.getters.getAuthUserConversations;
		  },
		  authUserActiveNotificationCount(){
			  return this.$store.getters.getAuthUserActiveNotificationCount;
      },
		  authUserActiveConversationCount(){
			  return this.$store.getters.getAuthUserActiveConversationCount;
      },
      authUserActiveNotificationSum(){
	      return this.$store.getters.getAuthUserActiveNotificationCount + this.$store.getters.getAuthUserActiveConversationCount;
      }
	  },
    methods : {
  		async onSignOut()
      {
			  let response = await fetch('api/signout', {
				  credentials: 'include',
				  method: 'POST',
				  headers: {
					  'Accept': 'application/json',
					  'Content-Type': 'application/json'
				  }
			  });
			
			  if(response.status === 200)
			  {
				  //this.$store.dispatch('setIsAuthenticated', false);
				  this.$store.dispatch('setAuthUser', {});
				  this.$router.push('auth');
        }
      },
  		openConversation(index)
      {
        this.updateAuthUserConversations().then( response => {
        	console.log(response[index])
        })
      },
      async postConversationMessage(ConversationId, Text)
      {
	      let formData = new FormData();
	
	      formData.append('ConversationId', ConversationId);
	      formData.append('Text', Text);
	      
	      let response = await fetch('api/user/conversation_message', {
		      credentials: 'include',
		      method: 'POST',
		      headers: {
			      'Accept': 'application/json',
			      'Content-Type': 'application/json'
		      },
		      body: formData
	      });
	      
	      let conversation = await response.json();
	      
	      console.log(conversation);
        
        return conversation;
      },
  		async updateAuthUserNotifications()
      {
	      let response = await fetch('/api/user/notifications', {
		      method: 'GET',
		      credentials : 'include',
		      headers : {
			      'Content-Type' : 'application/json',
			      'X-Requested-With' : 'XMLHttpRequest',
		      }
	      });
       
	      if(response.status !== 200) return false;
	      if(!response.json) return false;

	      let notificationData = await response.json();
	      
	      try
        {
		      JSON.stringify(notificationData);
	      }
	      catch (e)
        {
		      return false;
	      }
       
	      this.$store.dispatch('setAuthUserNotifications', notificationData || []);
	
	      return this.authUserNotifications;
      },
	    async updateAuthUserConversations()
	    {
		    let response = await fetch('/api/user/conversations', {
			    method: 'GET',
			    credentials : 'include',
			    headers : {
				    'Content-Type' : 'application/json',
				    'X-Requested-With' : 'XMLHttpRequest',
			    }
		    });
		    
		    if(response.status !== 200) return false;
		    if(!response.json) return false;
		
		    let conversationData = await response.json();
      
		    try
        {
			   JSON.stringify(conversationData);
		    }
		    catch (e)
        {
			    return false;
		    }
		    
		    this.$store.dispatch('setAuthUserConversations', conversationData || []);
		
		    return this.authUserConversations;
	    }
    },
    created()
    {
    	if(this.isAuthenticated)
    	{
		    this.updateAuthUserNotifications();
		    this.updateAuthUserConversations();
		    setInterval(() => this.updateAuthUserNotifications(), this.services.notification.updateInterval);
		    setInterval(() => this.updateAuthUserConversations(), this.services.conversation.updateInterval);
      }
    }
  }
</script>
