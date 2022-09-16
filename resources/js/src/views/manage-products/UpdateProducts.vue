<template>
  <b-row>
    <b-col cols="12">
      <b-card-code title="Update Product">
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
                  <validation-provider #default="{ errors }" name="Product Type" rules="required">
                    <b-form-select v-model="productType" :options="product_type"/>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Product Name" rules="required">
                    <b-form-input
                      v-model="productName"
                      :state="errors.length > 0 ? false:null"
                      type="text"
                      placeholder="Product Name"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Width" rules="required">
                    <b-form-input
                      v-model="width"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Product Width"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Length" rules="required">
                    <b-form-input
                      v-model="length"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Product Length"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="Weight" rules="required">
                    <b-form-input
                      v-model="weight"
                      type="text"
                      :state="errors.length > 0 ? false:null"
                      placeholder="Product Weight"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>

              <b-col md="6">
                <b-form-group>
                  <validation-provider #default="{ errors }" name="description" rules="required">
                    <b-form-textarea
                      id="textarea"
                      v-model="description"
                      placeholder="Add Description..."
                      rows="2"
                      max-rows="6"
                    ></b-form-textarea>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                </b-form-group>
              </b-col>
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
  BFormCheckbox,
  BFormTextarea
} from "bootstrap-vue";
import { required } from "@validations";
import AdminApi from "../../../api/admin";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import router from "@/router";
import Admin from "../../../api/admin";

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
    BFormTextarea
  },
  data() {
    return {
      required,
      validationErrors: "",
      productName: "",
      length: "",
      width: "",
      weight: "",
      description: "",
      productType: null,
      product_type: [{ value: null, text: "Select a type" }],
    productId : this.$route.params.id,
    };
  },
  created() {
      this.getProductTypes();
    this.getSingleProduct(this.productId);
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.validationErrors = "";
          AdminApi.updateProduct(
            (this.info = {
              name: this.productName,
              length: this.length,
              width: this.width,
              weight: this.weight,
              description: this.description,
              type_id: this.productType,
              id:this.productId
             
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
    },
    getProductTypes() {
      AdminApi.getProductTypes(
        res => {
          console.log("the getProductTypes response is ", res.data);
          for (let i = 0; i < res.data.length; i++) {
            this.product_type.push({
              value: res.data[i].id,
              text: res.data[i].type
            });
          }
        },
        err => {
          console.log(err);
        }
      );
    },
    getSingleProduct(productId) {
      Admin.getSingleProduct(
        productId,
        res => {
          console.log('the getsingle product response is', res.data);
          this.productName = res.data.name,
          this.length = res.data.length,
          this.width = res.data.width,
          this.weight = res.data.weight,
          this.description = res.data.description,
          this.productType = res.data.type_id
          
        },
        err => {
          console.log(err);
        }
      );
    }
  }
};
</script>