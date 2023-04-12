<template>
  <div class="container-fluid">
    <div class="row">
      <!-- <pre>Check this data on created : {{ getUserDetails }}</pre> -->
      <div class="col-md-12">
        <div class="form-group row align-items-center">
          <div class="col-md-12">
            <div class="profile-img-edit">
              <div class="crm-profile-img-edit">
                <img v-if="getUserDetails?.relationships?.settings?.data?.attributes?.avatar?.md !== null" :src="getUserDetails?.relationships?.settings?.data?.attributes?.avatar?.md" alt="user" />
                <img v-else class="crm-profile-pic rounded-circle avatar-100" src="../../../../assets/images/user/11.png" alt="profile-pic" />
                <form>
                  <div class="crm-p-image bg-primary" @click="$refs.fileInput.click()">
                    <i class="las la-pen upload-button"></i>
                    <input ref="fileInput" style="display: none" type="file" accept="image/*" @change.prevent="selectNewAvatar" />
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body p-0">
            <div class="iq-edit-list usr-edit">
              <tab-nav :pills="true" extraclass="iq-edit-profile d-flex">
                <tab-nav-items :active="true" id="personal" dataToggle="pill" ariaControls="personal-information" title=" Profile Settings" liClass=" col-md-3 p-0" />
                <tab-nav-items :active="false" id="chang" dataToggle="pill" ariaControls="chang-pwd" title=" Security" liClass=" col-md-3 p-0" />
                <!-- <tab-nav-items :active="false" id="email" dataToggle="pill" ariaControls="emailandsms" title=" Storage" liClass=" col-md-3 p-0" /> -->
                <!-- <tab-nav-items :active="false" id="manage" dataToggle="pill" ariaControls="manage-contact" title=" Manage Contact" liClass=" col-md-3 p-0" /> -->
              </tab-nav>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="iq-edit-list-data">
          <tab-content>
            <!-- ProfileSettings :: START -->
            <tab-content-item :active="true" id="personal-information" aria-labelled-by="personal">
              <div class="container-fluid">
                <form>
                  <!-- accountSettings :: start -->
                  <div class="card">
                    <div class="card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                        <h4 class="card-title"><i class="ri-pencil-line"></i> Profile Settings</h4>
                      </div>
                    </div>
                    <form>
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="form-group col-sm-6">
                            <label for="fname">First Name:</label>
                            <input v-model="f_name" :placeholder="this.getUserDetails?.relationships?.settings?.data?.attributes?.first_name" type="text" class="form-control" id="fname" />
                          </div>
                          <div class="form-group col-sm-6">
                            <label for="lname">Last Name:</label>
                            <input v-model="l_name" :placeholder="this.getUserDetails?.relationships?.settings?.data?.attributes?.last_name" type="text" class="form-control" id="lname" />
                          </div>
                          <div class="form-group col-sm-12">
                            <label>GMT:</label>
                            <select disabled style="cursor: not-allowed" class="form-control" id="exampleFormControlSelect4">
                              <option>California</option>
                              <option>Florida</option>
                              <option selected="">Georgia</option>
                              <option>Connecticut</option>
                              <option>Louisiana</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- accountSettings :: end -->

                  <!-- billingInformation :: start -->
                  <div class="card">
                    <div class="card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                        <h4 class="card-title"><i class="ri-pencil-line"></i> Address Information</h4>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="form-group col-sm-12">
                          <label>Address:</label>
                          <textarea disabled style="cursor: not-allowed; line-height: 22px" class="form-control" name="address" rows="5">
                             37 Cardinal Lane
                             Petersburg, VA 23803
                             United States of America
                             Zip Code: 85001
                          </textarea>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cname">City:</label>
                          <input disabled style="cursor: not-allowed" type="text" class="form-control" id="cname" value="Atlanta" />
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cname">Postal Coce:</label>
                          <input disabled style="cursor: not-allowed" type="text" class="form-control" id="pcode" value="123456" />
                        </div>
                        <div class="form-group col-sm-6">
                          <label>Country:</label>
                          <select disabled style="cursor: not-allowed" class="form-control" id="exampleFormControlSelect3">
                            <option>Caneda</option>
                            <option>Noida</option>
                            <option selected="">USA</option>
                            <option>India</option>
                            <option>Africa</option>
                          </select>
                        </div>
                        <div class="form-group col-sm-6">
                          <label>State:</label>
                          <select disabled style="cursor: not-allowed" class="form-control" id="exampleFormControlSelect5">
                            <option>California</option>
                            <option>Florida</option>
                            <option selected="">Georgia</option>
                            <option>Connecticut</option>
                            <option>Louisiana</option>
                          </select>
                        </div>
                        <div class="form-group col-sm-6">
                          <label for="cname">Phone Number:</label>
                          <input disabled style="cursor: not-allowed" type="text" class="form-control" id="pnumber" value="123456" />
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" @click.prevent="updateUsername">Save</button>
                      <button type="reset" class="btn iq-bg-danger">Cancel</button>
                    </div>
                  </div>
                  <!-- billingInformation :: end -->
                </form>
              </div>
            </tab-content-item>
            <!-- ProfileSettings :: end -->

            <!-- SecurityAndAPI :: start -->
            <tab-content-item :active="false" id="chang-pwd" aria-labelled-by="chang">
              <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                    <h4 class="card-title"><i class="ri-pencil-line"></i> Change Your Password</h4>
                  </div>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="cpass">Current Password:</label>
                      <!-- <a href="javascripe:void();" class="float-right">Forgot Password</a> -->
                      <input v-model="current_password" type="Password" class="form-control" id="cpass" />
                    </div>
                    <div class="form-group">
                      <label for="npass">New Password:</label>
                      <input v-model="password" type="Password" class="form-control" id="npass" />
                    </div>
                    <div class="form-group">
                      <label for="cnpass">Confirm Password:</label>
                      <input v-model="password_confirmation" type="Password" class="form-control" id="cnpass" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" @click.prevent="setNewPasswordFn">Store New Password</button>
                    <!-- <button type="reset" class="btn iq-bg-danger">Reset</button> -->
                  </form>
                </div>
              </div>
            </tab-content-item>
            <!-- SecurityAndAPI :: end -->

            <!-- Storage :: start -->
            <!-- <tab-content-item :active="false" id="emailandsms" aria-labelled-by="email">
             <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                    <h4 class="card-title">Email and SMS</h4>
                  </div>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group row align-items-center">
                      <label class="col-md-3" for="emailnotification">Email Notification:</label>
                      <div class="col-md-9 custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="emailnotification" checked="" />
                        <label class="custom-control-label" for="emailnotification"></label>
                      </div>
                    </div>
                    <div class="form-group row align-items-center">
                      <label class="col-md-3" for="smsnotification">SMS Notification:</label>
                      <div class="col-md-9 custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="smsnotification" checked="" />
                        <label class="custom-control-label" for="smsnotification"></label>
                      </div>
                    </div>
                    <div class="form-group row align-items-center">
                      <label class="col-md-3" for="npass">When To Email</label>
                      <div class="col-md-9">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email01" />
                          <label class="custom-control-label" for="email01">You have new notifications.</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email02" />
                          <label class="custom-control-label" for="email02">You're sent a direct message</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email03" checked="" />
                          <label class="custom-control-label" for="email03">Someone adds you as a connection</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row align-items-center">
                      <label class="col-md-3" for="npass">When To Escalate Emails</label>
                      <div class="col-md-9">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email04" />
                          <label class="custom-control-label" for="email04"> Upon new order.</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email05" />
                          <label class="custom-control-label" for="email05"> New membership approval</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="email06" checked="" />
                          <label class="custom-control-label" for="email06"> Member registration</label>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn iq-bg-danger">Cancel</button>
                  </form>
                </div>
              </div> 
            </tab-content-item>-->
            <!-- Storage :: end -->
            <!-- <tab-content-item :active="false" id="manage-contact" aria-labelled-by="manage">
              <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <div class="iq-header-title">
                    <h4 class="card-title">Manage Contact</h4>
                  </div>
                </div>
                <div class="card-body">
                  <form>
                    <div class="form-group">
                      <label for="cno">Contact Number:</label>
                      <input type="text" class="form-control" id="cno" value="001 2536 123 458" />
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="text" class="form-control" id="email" value="Barryjone@demo.com" />
                    </div>
                    <div class="form-group">
                      <label for="url">Url:</label>
                      <input type="text" class="form-control" id="url" value="https://getbootstrap.com" />
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn iq-bg-danger">Cancel</button>
                  </form>
                </div>
              </div>
            </tab-content-item> -->
          </tab-content>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="js">
// import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import tabNav from '../../../../components/tab/tab-nav.vue'
export default {
  components: { tabNav },
  name: 'UserProfileEdit',
  data() {
    return {
      f_name: '',
      l_name: '',
      current_password: '',
      password: '',
      password_confirmation: '',
      selectedAvatar: null,
      fullName: ''
    }
  },
  computed: {
    ...mapGetters('Auth', ['getUserDetails']),
  },
  methods: {
    ...mapActions('Auth', ['HbGetLoggedInUserAn', 'HbSetNewPassword', 'HbChangeAvatar', 'HbUpdateProfile']),
    updateUsername() {
      if (this.f_name || this.l_name) {
        this.fullName = this.f_name + this.l_name
        const payload = {
          _method: 'patch',
          name: this.fullName,
        }
        this.HbSetNewPassword(payload);
      }
    },
    setNewPasswordFn() {
      if (this.f_name || this.l_name) {
        this.fullName = this.f_name + this.l_name;
      }
      const payload = {
        _method: 'patch',
        name: this.fullName ? this.fullName : '',
        current_password: this.current_password,
        password: this.password,
        password_confirmation: this.password_confirmation
      }
      this.HbSetNewPassword(payload);
    },
    selectNewAvatar(event) {
      this.selectedAvatar = event.target.files[0]
      const fd = new FormData();
      fd.append('_method', 'patch')
      fd.append('uuid', 'uuid')
      fd.append('file_storage_option_id', 1)
      fd.append('storage_limit_mb', 102)
      fd.append('avatar', this.selectedAvatar)
      this.HbChangeAvatar(fd);
    }
  },
  created() {
    this.HbGetLoggedInUserAn();
  }
}
</script>
