<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Login v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <!-- <b-img
          :src="appLogoImage"
          alt="logo"
        /> -->
        </b-link>

        <!-- <b-card-title class="mb-1">
          Welcome to Vuexy! 👋
        </b-card-title>
        <b-card-text class="mb-2">
          Please sign-in to your account and start the adventure
        </b-card-text> -->

        <!-- form -->
        <validation-observer
          ref="loginValidation"
          #default="{invalid}"
        >
          <b-form
            class="auth-login-form mt-2"
            @submit.prevent
          >

            <!-- email -->
            <b-form-group
              label-for="email"
              label="Email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="email"
                  v-model="userEmail"
                  name="login-email"
                  :state="errors.length > 0 ? false:null"
                  placeholder="john@example.com"
                  autofocus
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- password -->
            <b-form-group>
              <div class="d-flex justify-content-between">
                <label for="password">Password</label>
                <b-link :to="{name:'forgot-password'}">
                  <small>Forgot Password?</small>
                </b-link>
              </div>
              <validation-provider
                #default="{ errors }"
                name="Password"
                rules="required"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="password"
                    v-model="password"
                    :type="passwordFieldType"
                    class="form-control-merge"
                    :state="errors.length > 0 ? false:null"
                    name="login-password"
                    placeholder="Password"
                  />

                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="passwordToggleIcon"
                      @click="togglePasswordVisibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- Role -->
            <b-form-group
              label-for="Role"
              label="Select Role"
            >
              <validation-provider
                #default="{ errors }"
                name="Role"
                rules="required"
              >
               <b-form-select v-model="userLevel" :options="user_level" v-on:change="myFunction($event)"/>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

       

            <!-- checkbox -->
            <b-form-group>
              <b-form-checkbox
                id="remember-me"
                v-model="status"
                name="checkbox-1"
              >
                Remember Me
              </b-form-checkbox>
            </b-form-group>

            <!-- submit button -->
            <b-button
              variant="primary"
              type="submit"
              block
              :disabled="invalid"
               @click="validationForm"
            >
              Sign in
            </b-button>
            <b-button
              variant="primary"
              type="submit"
              block
              :disabled="invalid"
               @click="sendMail"
            >
              Send Mail
            </b-button>
            
          </b-form>
        </validation-observer>

        <!-- <b-card-text class="text-center mt-2">
          <span>New on our platform? </span>
          <b-link :to="{name:'auth-register-v1'}">
            <span>Create an account</span>
          </b-link>
        </b-card-text> -->

        <!-- <div class="divider my-2">
          <div class="divider-text">
            or
          </div>
        </div> -->

        <!-- social button -->
        <div class="auth-footer-btn d-flex justify-content-center">
          <!-- <b-button
            href="javascript:void(0)"
            variant="facebook"
          >
            <feather-icon icon="FacebookIcon" />
          </b-button>
          <b-button
            href="javascript:void(0)"
            variant="twitter"
          >
            <feather-icon icon="TwitterIcon" />
          </b-button>
          <b-button
            href="javascript:void(0)"
            variant="google"
          >
            <feather-icon icon="MailIcon" />
          </b-button>
          <b-button
            href="javascript:void(0)"
            variant="github"
          >
            <feather-icon icon="GithubIcon" />
          </b-button> -->
        </div>
      </b-card>
      <!-- /Login v1 -->
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BButton,
  BForm,
  BFormInput,
  BFormGroup,
  BCard,
  BLink,
  BImg,
  BCardTitle,
  BCardText,
  BInputGroup,
  BInputGroupAppend,
  BFormCheckbox,
   BFormSelect,
} from 'bootstrap-vue'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import ValidateUser from '../../api/login' 
import AdminApi from "../../api/admin";

export default {
  components: {
    // BSV
    BButton,
    BForm,
    BFormInput,
    BFormGroup,
    BCard,
    BCardTitle,
    BLink,
    BImg,
    VuexyLogo,
    BCardText,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    ValidationProvider,
    ValidationObserver,
     BFormSelect,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
    	appLogoImage: require('@/assets/images/logo/logo.png'),
		userEmail: '',
		password: '',
		status: '',
		// validation rules
		required,
    email,
    user_level: [{
      value:null, text:"Select a Role"
    }],
      userLevel: null,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    
  },
  created()
  {
    this.getAllUserLevels();
  },

  methods: {
    myFunction(e)
    {
       console.log('the userLevel var is',this.userLevel);
    },
    sendMail()
    {
      alert('ok');
      ValidateUser.sendMail(
        res=>{
          console.log('send mail response is', res);
        },
        err=>{
          console.log(err);
        }
      );
    },
    getAllUserLevels() {
      ValidateUser.getData(
        "getAllRoles",
        res => {
            //console.log('the getAllUserLevels response is',res.data);
          for (let i = 0; i < res.data.length; i++) {
            this.user_level.push({
              value: res.data[i].id,
              text: res.data[i].user_level
            });
          }
         
        },
        err => {
          console.log(err);
        }
      );
    },
    validationForm() {
      this.$refs.loginValidation.validate().then(success => {
        if (success) {
          var info = {
            "email" : this.userEmail,
            "password" : this.password,
            "user_level": this.userLevel
          }
          ValidateUser.getUserInfo(
            info, 
            data=>{
              if(data.success){
                console.log(data);
                //console.log(this.$route);
                 //this.$emit('user',data);
                this.$router.push({ name: 'dashboard-analytics',  params: {user: data.data }});
              }else{
                this.$toast({
                  component: ToastificationContent,
                  props: {
                    title: 'Invalid Credentials',
                    text: 'Email or Password is incorrect',
                    icon: 'UserIcon',
                    variant: 'danger',
                  },
                })
              }
            },
            err=>{
              console.log('the error is',err);
            }
          )
          // this.$toast({
          //   component: ToastificationContent,
          //   props: {
          //     title: 'Form Submitted',
          //     icon: 'EditIcon',
          //     variant: 'success',
          //   },
          // })
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/pages/page-auth.scss';
</style>
