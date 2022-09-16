<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Create New User">
        <div v-if="validationErrors">
          <ul class="alert alert-danger">
            <li v-for="(value, key, index) in validationErrors">{{ value }}</li>
          </ul>
        </div>
        <validation-observer ref="simpleRules">
          <b-form>
            <b-row>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="name" rules="required">
                    <b-form-input
                      v-model="name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <!-- <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="last_name"
                    rules="required"
                >
                    <b-form-input
                    v-model="last_name"
                    :state="errors.length > 0 ? false:null"
                    type="text"
                    placeholder="Please Enter Last Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
              </b-col>-->
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Country" rules="required">
                    <b-form-input
                      v-model="country"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Country Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Province" rules="required">
                    <b-form-input
                      v-model="province"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Province Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="City" rules="required">
                    <b-form-input
                      v-model="city"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter City Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Address" rules="required">
                    <b-form-input
                      v-model="address"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Address"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Postcode" rules="required">
                    <b-form-input
                      v-model="postcode"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Postcode"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Phone" rules="required">
                    <b-form-input
                      v-model="phone"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Phone Number"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Contact Number" rules="required">
                    <b-form-input
                      v-model="contact"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Contact Number"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Currency" rules="required">
                    <b-form-select v-model="currencyId" :options="currency"/>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <!-- <b-col md="6">
                <b-form-group>
                <validation-provider
                    #default="{ errors }"
                    name="username"
                    rules="required"
                >
                    <b-form-input
                    v-model="username"
                    :state="errors.length > 0 ? false:null"
                    type="text"
                    placeholder="Please Enter Username"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
                </b-form-group>
              </b-col>-->
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="email" rules="required">
                    <b-form-input
                      v-model="email"
                      :state="errors.length > 0 ? false:null"
                      type="email"
                      placeholder="Please Enter Email"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider
                    #default="{ errors }"
                    name="password"
                    vid="password"
                    rules="required"
                  >
                    <b-form-input
                      v-model="password"
                      type="password"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Your Password"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider
                    #default="{ errors }"
                    name="passwordConfirm"
                    rules="required"
                  >
                    <b-form-input
                      v-model="passwordConfirm"
                      :state="errors.length > 0 ? false:null"
                      type="password"
                      placeholder="Confirm Password"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Status" rules="required">
                    <b-form-select v-model="status" :options="options"/>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <!-- <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="User Level" rules="required">
                    <b-form-select v-model="userLevel" :options="user_level"/>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col> -->

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="User Level" rules="required">
                    <v-select
                      v-model="userLevel"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      multiple
                      label="text"
                      :options="user_level"
                      v-on:input="myFunction($event)"
                      placeholder="Select User Role(s)"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <!-- ware house details -->
              <template v-if="userLevel === -1">
                <b-col md="12">
                  <br>
                  <h4>Warehouse Detail</h4>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider
                      #default="{ errors }"
                      name="Warehouse name"
                      rules="required"
                    >
                      <b-form-input
                        v-model="wName"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Warehouse name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Email">
                      <b-form-input
                        v-model="wEmail"
                        :state="errors.length > 0 ? false:null"
                        type="email"
                        placeholder="Please Enter Email"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider
                      #default="{ errors }"
                      name="Location Index"
                      rules="required"
                    >
                      <b-form-input
                        v-model="wLocationIndex"
                        :state="errors.length > 0 ? false:null"
                        type="number"
                        placeholder="Location Index"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Country" rules="required">
                      <b-form-input
                        v-model="wCountry"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Country Name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Province" rules="required">
                      <b-form-input
                        v-model="wProvince"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Province Name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="City" rules="required">
                      <b-form-input
                        v-model="wCity"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter City Name"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Address" rules="required">
                      <b-form-input
                        v-model="wAddress"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Address"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Postcode" rules="required">
                      <b-form-input
                        v-model="wPostcode"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Postcode"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider #default="{ errors }" name="Phone" rules="required">
                      <b-form-input
                        v-model="wPhone"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Phone Number"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <b-col md="6">
                  <b-form-group>
                    <validation-provider
                      #default="{ errors }"
                      name="Contact Number"
                      rules="required"
                    >
                      <b-form-input
                        v-model="wContact"
                        :state="errors.length > 0 ? false:null"
                        type="text"
                        placeholder="Please Enter Contact Number"
                      />
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
              </template>

              <!-- <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isChangePassword">Forces the user to change their Password on next login</b-form-checkbox>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isRandomPassword">Generate a random Password which will be emailed to the user automatically</b-form-checkbox>
                </b-form-group>
            </b-col>
            <b-col md="12">
                <b-form-group>
                    <b-form-checkbox v-model="isAccountSummary">Send account summary to user</b-form-checkbox>
                </b-form-group>
              </b-col>-->

              <b-col md="12">
                <b-button variant="primary" type="submit" @click.prevent="validationForm">Submit</b-button>
              </b-col>
            </b-row>
          </b-form>
        </validation-observer>
      </b-card-code>
    </b-col>
  </b-row>
</template>
<script>
import BCardCode from "@core/components/b-card-code";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import {
  BFormInput,
  BFormGroup,
  BForm,
  BRow,
  BCol,
  BButton,
  BFormSelect,
  BFormCheckbox
} from "bootstrap-vue";
import { required, email, confirmed } from "@validations";
import vSelect from "vue-select";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from "@/router";

export default {
  components: {
    BCardCode,
    ValidationProvider,
    ValidationObserver,
    BFormInput,
    BFormGroup,
    BForm,
    BRow,
    BCol,
    BButton,
    BFormSelect,
    BFormCheckbox,
    vSelect
  },
  data() {
    return {
      required,
      password: "",
      passwordConfirm: "",
      email: "",
      confirmed,
      validationErrors: "",
      info: "",
      name: "",
      //   last_name:'',
      country: "",
      province: "",
      city: "",
      address: "",
      postcode: "",
      phone: "",
      contact: "",
      currencyId: null,

      wName: "",
      wEmail: "",
      wLocationIndex: "",
      wCountry: "",
      wProvince: "",
      wCity: "",
      wAddress: "",
      wPostcode: "",
      wPhone: "",
      wContact: "",

      currency: [{ value: null, text: "Please select a currency" }],
      options: [
        { value: null, text: "Please select an option" },
        { value: 1, text: "Enabled" },
        { value: 0, text: "Disabled" }
      ],
      status: null,
      user_level: [],
      userLevel: [],
      isAccountSummary: 0,
      isRandomPassword: 0,
      isChangePassword: 0,
      
    };
  },
  created() {
    this.getAllCurrencies();
    this.getAllUserLevels();
  },
  methods: {
      myFunction(e)
      {
          //alert('ok');
          console.log('the event is ',e);
          console.log('the user level are ',this.userLevel);
      },
    getAllCurrencies() {
      AdminApi.getData(
        "getAllCurrencies",
        res => {
          for (let i = 0; i < res.data.length; i++) {
            this.currency.push({
              value: res.data[i].id,
              text: res.data[i].currency
            });
          }
          //console.log('the get currency response is',res.data);
        },
        err => {
          console.log(err);
        }
      );
    },
    getAllUserLevels() {
      AdminApi.getData(
        "getAllUserLevels",
        res => {
           
          for (let i = 0; i < res.data.length; i++) {
            this.user_level.push({
              value: res.data[i].id,
              text: res.data[i].user_level
            });
          }
          //console.log('the get currency response is',res.data);
        },
        err => {
          console.log(err);
        }
      );
    },
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          AdminApi.createUser(
            (this.info = {
              name: this.name,
              //   "last_name" : this.last_name,
              country: this.country,
              province: this.province,
              city: this.city,
              address: this.address,
              postcode: this.postcode,
              currency_id: this.currencyId,
              phone: this.phone,
              contact: this.contact,
              email: this.email,
              password: this.password,
              confirm_password: this.passwordConfirm,
              //   "isAccountSummary" : this.isAccountSummary,
              isRandomPassword: this.isRandomPassword,
              //   "isChangePassword" : this.isChangePassword,
              user_level: this.userLevel,
              status: this.status,

              w_name: this.wName,
              w_email: this.wEmail,
              w_country: this.wCountry,
              w_province: this.wProvince,
              w_city: this.wCity,
              w_address: this.wAddress,
              w_postcode: this.wPostcode,
              w_phone: this.wPhone,
              w_contact: this.wContact,
              w_location_index: this.wLocationIndex
            }),
            data => {
              if (data.success) {
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: "Success!",
                    text: data.message,
                    icon: "UserIcon",
                    variant: "success"
                  }
                });
                //router.push({ name: "manage-users" });
              } else {
                if (data.status == 422) {
                  this.validationErrors = data.message;
                } else {
                  this.$toast({
                    component: ToastificationContent,
                    props: {
                      title: "Failed",
                      text: data.message,
                      icon: "errorIcon",
                      variant: "outline-danger"
                    }
                  });
                }
              }
            },
            err => {
              console.log(err);
            }
          );
        }
      });
    }
  }
};
</script>