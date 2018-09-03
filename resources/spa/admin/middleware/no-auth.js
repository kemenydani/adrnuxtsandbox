export default function({ store, redirect })
{
		if(store.getters.getIsAuthenticated) return redirect('/')
}
