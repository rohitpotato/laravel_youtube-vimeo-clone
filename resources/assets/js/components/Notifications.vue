<template>
	
	<li class="dropdown">
			
		<a href="" class="dropdown-toggle" data-toggle = "dropdown">Notifications</a>



		<ul class="dropdown-menu">
			
			<li v-for="notification in notifications">
					
				<a :href="notification.data.link" v-text = "notification.data.message" @click	="markAsRead(notification)"></a>

			</li>
		
		</ul>

	</li>



</template>


<script>
	
	export default {

		data() {

			return { notifications: false}
		},

		props: {

			userId: null,
		},

		created() {

			axios.get("/codetube/public/user/" + this.userId + '/notifications')

				.then(response => this.notifications = response.data);
		},

		methods: {

			markAsRead(notification) {

				axios.delete("/codetube/public/profiles/" + this.userId + "/notifications/" + notification.id)
			}
		}
	}

</script>