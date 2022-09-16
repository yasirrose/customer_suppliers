<template>
  <b-card>
    <b-row>
      <b-col md="8">
        <b-card no-body>
          <b-card-header>
            <b-card-title>
              <h4>Warehouse Detail</h4>
            </b-card-title>
          </b-card-header>
          <b-card-body>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Warehouse Name:</dt>
              <dd class="col-sm-8">{{name}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Email:</dt>
              <dd class="col-sm-8">{{email}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Phone No.:</dt>
              <dd class="col-sm-8">{{phone}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Contact No.:</dt>
              <dd class="col-sm-8">{{contact}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Country:</dt>
              <dd class="col-sm-8">{{country}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">City:</dt>
              <dd class="col-sm-8">{{city}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Province:</dt>
              <dd class="col-sm-8">{{province}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Address:</dt>
              <dd class="col-sm-8">{{address}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Postcode:</dt>
              <dd class="col-sm-8">{{postcode}}</dd>
            </dl>
            
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Created on:</dt>
              <dd class="col-sm-8">{{createdAt | formatDate}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Last Modified on:</dt>
              <dd class="col-sm-8">{{updatedAt | formatDate}}</dd>
            </dl>

          </b-card-body>
        </b-card>
      </b-col>

      <!-- buttons -->
      <!-- <b-col cols="12">
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          class="mr-1 mt-1"
        >Save changes</b-button>
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          type="reset"
          class="mt-1"
          variant="outline-secondary"
        >Cancel</b-button>
      </b-col>-->
      <!--/ buttons -->
    </b-row>
  </b-card>
</template>

<script>
import {
  BButton,
  BRow,
  BCol,
  BCard,
  BFormCheckbox,
  BTabs,
  BTab,
  BCardTitle,
  BCardText,
  BCardHeader,
  BCardBody,
  BBadge
} from "bootstrap-vue";
import {} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import AdminApi from "../../../../api/admin";

export default {
  components: {
    BButton,
    BRow,
    BCol,
    BCard,
    BFormCheckbox,
    BTabs,
    BTab,
    BCard,
    BCardTitle,
    BCardText,
    BCardHeader,
    BCardBody,
    BBadge
  },
  directives: {
    Ripple
  },
  props: {
    notificationData: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      name: "",
      email: "",
      country: "",
      province: "",
      city: "",
      address: "",
      postcode: "",
      phone: "",
      contact: "",
      currency: "",
      status: "",
      userLevel: [],
      createdAt: "",
      updatedAt: "",
      warehouseId: this.$route.params.id
    };
  },
  created() {
    this.getWarehouse(this.warehouseId);
    
  },
  computed: {
    statusVariant() {
      const statusColor = {
        /* eslint-disable key-spacing */
        1: "light-primary",
        0: "light-danger"
      };

      return status => statusColor[status];
    }
  },
  methods: {
    getWarehouse(warehouseId) {
      AdminApi.getRow(
        "getWarehouse",
        warehouseId,
        res => {
          console.log("the getWarehouse response is ", res.data);
          this.name = res.data.name;

          this.email = res.data.w_email;
          this.country = res.data.country;
          this.province = res.data.province;
          this.city = res.data.city;
          this.address = res.data.address;
          this.postcode = res.data.postcode;
          this.phone = res.data.phone;
          this.contact = res.data.contact;
          this.createdAt = res.data.created_at;
          this.updatedAt = res.data.updated_at;
          
        },
        err => {
          console.log(err);
        }
      );
    },
   
  }
};
</script>
