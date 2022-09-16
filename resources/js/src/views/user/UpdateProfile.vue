<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Profile">
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
                  <validation-provider #default="{ errors }" name="User Name" rules="required">
                    <b-form-input
                      v-model="name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter First Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <!-- <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="last_name" rules="required">
                    <b-form-input
                      v-model="last_name"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Please Enter Last Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col> -->
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

              <!-- submit button -->
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
  BFormSelect
} from "bootstrap-vue";
import { required, email, confirmed } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

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
    BFormSelect
  },
  data() {
    return {
      email: "",
      name: "",
      //last_name: "",
      country: "",
      province: "",
      city: "",
      address: "",
      postcode: "",
      phone: "",
      contact: "",
      currencyId: null,
      currency: [{ value: null, text: "Please select a currency" }],

      validationErrors: ""
    };
  },
  created() {
    this.getAllCurrencies();
    this.getProfileInfo()
  },
  methods: {
    getAllCurrencies() {
      AdminApi.getData(
        'getAllCurrencies',
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
    getProfileInfo() {
      AdminApi.getData(
        'getProfileInfo',
        res => {
         //console.log('the get profile response is ',res.data);
         this.name = res.data.name;
         //this.last_name = res.data.last_name;
         this.email = res.data.email;
         this.country = res.data.country;
         this.province = res.data.province;
         this.city = res.data.city;
        this.address = res.data.address;
        this.postcode = res.data.postcode;
        this.phone = res.data.phone;
        this.contact = res.data.contact;
        this.currencyId = res.data.currency_id;
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
          AdminApi.updateProfileInfo(
            (this.info = {
              name: this.name,
              //last_name: this.last_name,
              email: this.email,
              country: this.country,
              province: this.province,
              city: this.city,
              address: this.address,
              postcode: this.postcode,
              phone: this.phone,
              contact: this.contact,
              currency_id: this.currencyId,
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
                router.push({ name: "user-accounts" });
              } else {
                if (data.status == 422) {
                  this.validationErrors = data.message;
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