<template>
		
		<div class="subscribe-button" >
			
			{{ subscribers }} Subscribers &nbsp; &nbsp; <button class="btn btn-danger btn-xs" v-if="canSubscribe" @click.prevent="handle">{{ userSubscribed ? 'Unsubscribe' : 'Subscribe' }}</button>

		</div>

</template>

<script>
	
	export default {

		props: {

			channelSlug: null,

		},

		data() {

			return {

				subscribers: null,
				userSubscribed: false,
				canSubscribe: false,
			}

		},

		methods: {

			getSubscriptionStatus() {

				axios.get('/codetube/public/subscription/' + this.channelSlug).then((response) => {

					this.subscribers = response.data.count;
					this.userSubscribed = response.data.user_subscribed;
					this.canSubscribe = response.data.can_subscribe;

				});
			},

			handle() {

				if (this.userSubscribed) {

					this.unsubscribe();
				} else {

					this.subscribe();
				}
			},

			subscribe() {

				this.userSubscribed = true;
				 this.subscribers++;

				 axios.post('/codetube/public/subscription/' + this.channelSlug);


			},

			unsubscribe() {

				this.userSubscribed = false;
				 this.subscribers--;

				 axios.delete('/codetube/public/subscription/' + this.channelSlug);
			}

		},

		mounted() {

			this.getSubscriptionStatus();
		}
}

</script>