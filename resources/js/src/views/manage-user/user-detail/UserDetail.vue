<template>
  <b-tabs
    vertical
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >
    <!-- general tab -->
    <b-tab active>
      <!-- User Detail -->
      <template #title>
        <feather-icon icon="UserIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">User Detail</span>
      </template>
      <ViewUser/>
    </b-tab>



    <!-- Warehouse detail -->
    <b-tab>
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Warehouse(s) Detail</span>
      </template>
      <Warehouse/>
    </b-tab>

        <!-- Warehouse detail -->
    <!-- <b-tab>
      <template #title>
        <feather-icon icon="LockIcon" size="18" class="mr-50"/>
        <span class="font-weight-bold">Add Warehouse</span>
      </template>
      <AddWarehouse/>
    </b-tab>
     -->

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
import ViewUser from "./ViewUser.vue";
import AddWarehouse from "./AddWarehouse.vue";
import Warehouse from "./Warehouse.vue";


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
    ViewUser,
    Warehouse,
    AddWarehouse
  },
  data() {
    return {};
  }
  // beforeCreate() {
  //   this.$http.get('/data').then(res => { this.options = res.data })
  // },
};
</script>
