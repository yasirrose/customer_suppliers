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
        <span class="font-weight-bold">View Orders</span>
      </template>
      <AllOrders :userLevel="userLevel" :userId="userId"/>
    </b-tab>

    <!-- Create Orders -->
    <b-tab>
      <template #title v-if="$can('manage_orders_access','all')">
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Create Orders</span>
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
import AllOrders from "./AllOrders.vue";
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
    AllOrders,
    CreateOrders
   
  },
  data() {
    return {
      user:{},
      userLevel:Number,
      userId:Number
    };
  },
  // beforeCreate() {
  //   this.$http.get('/data').then(res => { this.options = res.data })
  // },

  created() {
     this.user = JSON.parse(localStorage.getItem("userData"));
     this.userLevel =  this.user.user_level_id;
      this.userId =  this.user.id;
     console.log('the user level' ,this.userLevel);

   

    
  }
};


</script>
