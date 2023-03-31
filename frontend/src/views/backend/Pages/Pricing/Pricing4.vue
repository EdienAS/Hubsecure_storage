<template>
     <div class="container-fluid">
         <b-row >
            <div class="pricing-custom-tab w-100">
               <div class="tab-title-info position-relative">
                  <b-col sm="12" class=" p-0">
                        <tab-nav :pills="true "  id="pricing-pills-tab" extraclass=" d-flex nav mb-5 align-items-center justify-content-center" role="tablist" >
                           <tab-nav-items :active="true" id="data1" ariaControls="pricing-data1" dataToggle="pill" role="tab" :ariaSelected="true" title="Daily"/>
                           <li class="nav-item">
                              <div class="avatar-30 star-circle"><i class="ri-star-fill"></i>
                              </div>
                           </li>
                           <tab-nav-items :active="false" id="services"  ariaControls="pricing-data2" role="tab" dataToggle="pill" :ariaSelected="false" title="Monthly" />
                        </tab-nav>
                  </b-col>
               </div>
                <tab-content >
                   <tab-content-item :active="true" id="pricing-data1" aria-labelled-by="data1">
                     <div class="row m-0">
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder">$26<small class="font-size-14 text-muted">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Max Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder">$39<small class="font-size-14 text-muted">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Average Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder">$48<small class="font-size-14 text-muted">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Minimum Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                     </div>
                   </tab-content-item>
                   <tab-content-item :active="false" id="pricing-data2" aria-labelled-by="data2">
                    <div class="d-flex align-items-center">
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header bg-primary text-white">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder text-white">$26<small class="font-size-14">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Max Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-primary mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header bg-success text-white">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder text-white">$26<small class="font-size-14">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Max Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-success mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="card card-block card-stretch card-height blog pricing-details">
                              <div class="card-body border text-center rounded">
                                 <div class="pricing-header bg-danger text-white">
                                    <div class="icon-data"><i class="ri-star-line"></i>
                                    </div>
                                    <h2 class="mb-4 display-5 font-weight-bolder text-white">$26<small class="font-size-14">/ Month</small></h2>
                                 </div>
                                 <h4 class="mb-3">Max Usage</h4>
                                 <ul class="list-unstyled mb-0 pricing-list">
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Lorem ipsum dolor sit amet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Consectetur adipiscing elit.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Integer molestie at massa.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Facilisis in pretium nisl aliquet.</li>
                                    <li><i class="lar la-check-circle text-primary mr-2 font-size-20"></i>Nulla volutpat aliquam velit.</li>
                                 </ul> <a href="#" class="btn btn-danger mt-5">Start Starter</a>
                              </div>
                           </div>
                        </div>
                     </div>
                   </tab-content-item>
                </tab-content>
            </div>
         </b-row>
      </div>
</template>
<script lang="js">
export default {
    name:'Pricing4'
}
</script>