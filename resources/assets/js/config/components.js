/**
 * Created by guy on 10/07/17.
 */
// Register Components
import Simplert from 'vue2-simplert'
Vue.component('Simplert', Simplert);

// Passport Components
Vue.component('passport-main', require('../components/passport/Main.vue'));
Vue.component('passport-clients', require('../components/passport/Clients.vue'));
Vue.component('passport-authorized-clients', require('../components/passport/AuthorizedClients.vue'));
Vue.component('passport-personal-access-tokens', require('../components/passport/PersonalAccessTokens.vue'));

// Weddings Listings
Vue.component('upcoming-weddings', require('../components/UpcomingWeddings.vue'));
Vue.component('wedding-excerpt', require('../components/WeddingExcerpt.vue'));

// Manage Wedding
Vue.component('edit-wedding-info', require('../components/ManageWedding/EditWeddingInfo.vue'));
Vue.component('wedding-vendors', require('../components/ManageWedding/WeddingVendors.vue'));
Vue.component('add-vendor', require('../components/ManageWedding/AddVendor.vue'));
Vue.component('wedding-guests', require('../components/ManageWedding/WeddingGuests.vue'));
Vue.component('add-guest', require('../components/ManageWedding/AddGuest.vue'));
Vue.component('wedding-budget', require('../components/ManageWedding/WeddingBudget.vue'));
Vue.component('wedding-events', require('../components/ManageWedding/WeddingEvents.vue'));
Vue.component('add-event', require('../components/ManageWedding/AddEvent.vue'));

// vendors
Vue.component('vendor-excerpt', require('../components/VendorExcerpt.vue'));

// professions
Vue.component('add-profession', require('../components/AddProfession.vue'));

// products
Vue.component('add-product', require('../components/products/AddProduct'));