
Vue.use(ELEMENT);

Vue.component('webinane-donation-modal', {
	template: '<div><slot></slot></div>',
	data: {
	},
	methods: {
		

	}
})
window.webinane_checkout_app = ''
function webinane_donation_vuejs() {
	var app = new Vue({
		el: '.webinane-donation-modal',
		data: {
			loading: false,
			step: 1,
			payment_method: '',
			recurring: false,
			billing_period: 'Month',
			amount: 0,
			post_id: 0,
			personal: {
				first_name: '',
				last_name: '',
				email: '',
				phone: '',
				address: '',
			},
			ccard: {
				exp_month: '',
				exp_year: '',
				number: '',
				code: ''
			},
			gateways: {},
			currencies: {},
			currency: 'USD',
			amount_slabs: [],
			collected_amt: 0,
			needed_amt: 0,
			error_message: '',
			showModalBox: false,
			validated: false,
		},
		mounted() {
			this.$on('webinane-checkout-form-validation', (val) => {
				this.validated = val
			})
		},
		watch:{
			step: function(old, newval) {
				if( jQuery.fn.select2 == 'function' ) {
					jQuery('select').select2()
				}
			},
			loading: function(newval, old) {

				if( newval === true ){
					jQuery('.donation-modal-wraper,.donation-modal-preloader').show();
				} else {
					jQuery('.donation-modal-wraper,.donation-modal-preloader').hide();
				}
			}
		},
		methods: {
			showCurrencyAmount() {
				this.step = 1
			},
			getwayActiveClass(gateway) {
				return (gateway == this.payment_method) ? 'wpdonation-button active' : 'wpdonation-button'
			},
			currencyStep() {
				if( this.amount < 1 ) {
					alert('Please enter or choose amount');
					return;
				}
				this.step = 2
			},
			getYears() {
				let d = new Date();
				let year = parseInt(d.getFullYear())

				return _.range(year, (year+10))
			},
			submit() {
				this.$emit('webinane-checkout-form-validation', this.validate());
				
				if( ! this.validated ) {
					return;
				}
				let thisis = this
				let $ = jQuery
				thisis.error_message = '';

				this.loading = true

				$.ajax({
					url: wpcm_data.ajaxurl,
					type: 'post',
					data: {
						action: wpcm_data.ajax_action, 
						nonce: wpcm_data.nonce, 
						callback: ['Webinane_Donation', 'donate_now'], 
						post_id: thisis.post_id,
						currency: thisis.currency,
						amount: thisis.amount,
						gateway: thisis.payment_method,
						recurring: thisis.recurring,
						info: thisis.personal,
						cc: thisis.ccard
					},
					success: function(res) {
						if(res.success !== undefined ) {
							if( res.success == false ) {
								thisis.error_message = res.data;
							}
						}
						if( res.type !== undefined ) {
							if( res.type == 'redirect') {
								window.location = res.url
							}
						}
					},
					complete: function(res) {
						thisis.loading = false
					}
				});
			},
			validate() {
				let error_found = false;

				let validation = {
					payment_method: 'Please select payment method', 
					amount: 'Please enter the amount to donate', 
					currency: 'Choose the currency to donate'
				}
				_.each(validation, (msg, field) => {
					if( ! this[field] && !error_found ) {

						this.$notify.error({
							title: 'Error',
				          	message: msg,
				          	offset: 30,
				        });
						error_found = true
					}
				})
				let personal = {
					first_name: 'Please enter first name',
					last_name: 'Please enter last name',
					email: 'Please enter valid email address',
					phone: 'Please enter your phone number',
					address: 'Please enter your address',
				}
				_.each(personal, (msg, field) => {
					if( ! this.personal[field] && ! error_found ) {

						this.$notify.error({
							title: 'Error',
				          	message: msg,
				          	offset: 30,
				        });
						error_found = true
					}
				})

				return (! error_found) ? true : false;
			}
		}
	})

	var causelist = new Vue({
		el: '.urgent-popup-list',
		data: {
			loading: false,
			
		},
		mounted: function() {
			//this.getData()
		},
		methods: {
			showModal(event) {
				//var modal = document.querySelector('.footer-donation-modal')
				//modal.querySelector('.donation-popup').style.display = 'block'
				document.querySelector('html').classList.add('modalOpen')
				app.showModalBox = true;
				if( jQuery.fn.select2 == 'function' ) {
					jQuery('select').select2()
				}

				app.post_id = event.target.getAttribute('data-post')
				this.getData()
			},
			getData() {
				let thisis = this
				let $ = jQuery
				app.loading = true

				$.ajax({
					url: wpcm_data.ajaxurl,
					type: 'post',
					data: {action: wpcm_data.ajax_action, nonce: wpcm_data.nonce, callback: ['Webinane_Donation', 'fontend_donation_form_data'], post_id: app.post_id},
					success: function(res) {
						app.currencies = res.data.currencies
						app.amount_slabs = res.data.amount
						app.gateways = res.data.gateways
						app.collected_amt = res.data.donations
						app.needed_amt = res.data.needed_amount

						$('.knob').knob()
					},
					complete: function(res) {
						app.loading = false
					}
				});
			}
		}
	})

	window.webinane_checkout_app = app

}

webinane_donation_vuejs();