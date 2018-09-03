import Vuex from 'vuex';

const createStore = () =>
{
	return new Vuex.Store(
	{
		state :
		{
			isAuthenticated : false,
			authUser: {},
			authUserNotifications: [],
			authUserConversations: []
		},
		mutations:
		{
			setAuthUser(state, userData)
			{
				state.authUser = userData;
			},
			setIsAuthenticated(state, bool)
			{
				state.isAuthenticated = bool;
			},
			setAuthUserNotifications(state, notificationData)
			{
				state.authUserNotifications = notificationData;
			},
			setAuthUserConversations(state, conversationData)
			{
				state.authUserConversations = conversationData;
			},
		},
		actions:
		{
			setAuthUser(vuexContext, userData = {})
			{
				vuexContext.commit('setAuthUser', userData);
				vuexContext.commit('setIsAuthenticated', !!Object.keys(userData).length);
			},
			setIsAuthenticated(vuexContext, bool)
			{
				vuexContext.commit('setIsAuthenticated', bool);
			},
			setAuthUserNotifications(vuexContext, notificationData)
			{
				vuexContext.commit('setAuthUserNotifications', notificationData);
			},
			setAuthUserConversations(vuexContext, conversationData)
			{
				vuexContext.commit('setAuthUserConversations', conversationData);
			},
		},
		getters :
		{
			getAuthUser(state)
			{
				return state.authUser;
			},
			getIsAuthenticated(state)
			{
				return state.isAuthenticated;
			},
			getAuthUserNotifications(state)
			{
				return state.authUserNotifications;
			},
			getAuthUserActiveNotificationCount(state)
			{
				return state.authUserNotifications.length || 0;
			},
			getAuthUserConversations(state)
			{
				return state.authUserConversations;
			},
			getAuthUserActiveConversationCount(state)
			{
				let activeConversationCount = 0;
				state.authUserConversations.forEach( item => activeConversationCount++);
				return activeConversationCount;
			},
		}
	});
};

export default createStore;
