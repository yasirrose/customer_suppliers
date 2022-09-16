<template>
  <b-card>
    <b-row>
      <b-col md="8">
        <b-card no-body>
          <b-card-header>
            <b-card-title>
              <h4>User Detail</h4>
            </b-card-title>
          </b-card-header>
          <b-card-body>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">User Name:</dt>
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
              <dt class="col-sm-3 offset-sm-1">Currency:</dt>
              <dd class="col-sm-8">{{currency}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Role(s):</dt>
              <dd class="col-sm-8">
                <span v-for="(user_level, i) in userLevel" :key="i">{{user_level.user_level }},&nbsp;</span>
              </dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Created on:</dt>
              <dd class="col-sm-8">{{createdAt | formatDate}}</dd>
            </dl>
            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Last Modified on:</dt>
              <dd class="col-sm-8">{{updatedAt | formatDate}}</dd>
            </dl>

            <dl class="row">
              <dt class="col-sm-3 offset-sm-1">Status:</dt>
              <dd class="col-sm-8">
                <b-badge v-if="status === 0" :variant="statusVariant(status)">Disabled</b-badge>
                <b-badge v-else-if="status === 1" :variant="statusVariant(status)">Enabled</b-badge>
              </dd>
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
      userId: this.$route.params.id
    };
  },
  created() {
    this.getUserDetail(this.userId);
    this.getUserLevels(this.userId);
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
    getUserDetail(userId) {
      AdminApi.getRow(
        "getUserDetail",
        userId,
        res => {
          console.log("the user detail response is ", res.data);
          this.name = res.data.name;

          this.email = res.data.email;
          this.country = res.data.country;
          this.province = res.data.province;
          this.city = res.data.city;
          this.address = res.data.address;
          this.postcode = res.data.postcode;
          this.phone = res.data.phone;
          this.contact = res.data.contact;
          this.createdAt = res.data.created_at;
          this.updatedAt = res.data.updated_at;
          this.status = res.data.status;
          this.currency = res.data.currency;
        },
        err => {
          console.log(err);
        }
      );
    },
    getUserLevels(userId) {
      AdminApi.getRow(
        "getUserLevels",
        userId,
        res => {
          //  for (let i = 0; i < res.data.length; i++) {
          //   this.userLevel[i] = res.data[i];

          // }
          this.userLevel = res.data;
          console.log("the getUserLevels response is", res.data);
        },
        err => {
          console.log(err);
        }
      );
    }
  }
};
</script>
