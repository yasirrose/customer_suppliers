<template>
  <b-tabs
    vertical
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >


    
    <!-- Add to groups -->
    <b-tab>
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">View Users</span>
      </template>
      <ViewOrders/>
    </b-tab>

    <!-- Manage MFA -->
    <b-tab>
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Add Users</span>
      </template>
      <CreateOrders/>
    </b-tab>

    <!-- notification -->
  </b-tabs>
</template>

<script>
import {
  BTabs,
  BTab,
  BRow,
  BCol,
  BCard,
  BCardTitle,
  BCardText,
  BCardHeader,
  BCardBody
} from "bootstrap-vue";
import ViewOrders from "./ViewOrders.vue";
import CreateOrders from "./CreateOrders.vue";
// import AddToGroups from "./AddToGroups.vue";


export default {
  components: {
    BTabs,
    BTab,
    BRow,
    BCol,
    BCard,
    BCardTitle,
    BCardText,
    BCardHeader,
    BCardBody,
    ViewOrders,
    CreateOrders
   
  },
  data() {
    return {};
  }
  // beforeCreate() {
  //   this.$http.get('/data').then(res => { this.options = res.data })
  // },
};
</script>
