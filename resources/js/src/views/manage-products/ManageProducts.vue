<template>
  <b-tabs
    vertical
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >


    
    <!-- View Products -->
    <b-tab>
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">View Products</span>
      </template>
      <AllProducts/>
    </b-tab>

    <!-- Create Product Types -->
    <b-tab v-if="user.user_level_id==1">
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Create Product Types</span>
      </template>
      <CreateProductTypes/>
    </b-tab>

    <!-- Create Products -->
    <b-tab v-if="user.user_level_id==1">
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Create Products</span>
      </template>
      <CreateProducts/>
    </b-tab>


    
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
import AllProducts from "./AllProducts.vue";
import CreateProducts from "./CreateProducts.vue";
import CreateProductTypes from "./CreateProductTypes.vue";
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
    AllProducts,
    CreateProducts,
    CreateProductTypes
   
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
     this.userLevel =  this.user.user_level;
      this.userId =  this.user.id;
     console.log('the user level' ,this.userLevel);

   

    
  }
};


</script>
