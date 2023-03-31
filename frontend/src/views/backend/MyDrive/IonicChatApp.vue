<template>
    <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                     <div class="d-flex align-items-center justify-content-between welcome-content mb-3">
                        <div class="navbar-breadcrumb">
                           <nav aria-label="breadcrumb">
                              <ul class="breadcrumb">
                                 <li class="breadcrumb-item"><router-link to="/">My Drive</router-link></li>
                                 <li class="breadcrumb-item active" aria-current="page">Iconic Chat App</li>
                              </ul>
                           </nav>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="list-grid-toggle mr-4" @click="change()">
                                <span class="icon icon-grid i-grid" v-if="data"><i class="ri-layout-grid-line font-size-20"></i></span>
                                <span class="icon i-list" v-else><i class="ri-list-check font-size-20"></i></span>
                                <span class="label label-list">List</span>
                            </div>
                            <DropdownToggle />
                        </div>
                     </div>
                </div>
            </div>

            <div v-if="data" class="icon icon-grid i-grid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch card-transparent">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <div class="header-title">
                                    <h4 class="card-title">Images</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-for="(data,index) in datas" :key="index" class="col-lg-3 col-md-6 col-sm-6">
                      <cardlist :data="data" />
                    </div>             
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch card-transparent">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <div class="header-title">
                                    <h4 class="card-title">Documents</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <div class="mb-4 text-center p-3 rounded iq-thumb">
                                    <div class="iq-image-overlay"></div>
                                    <a href="#" data-title="Books.pdf" :data-url="`${this.baseUrl}/doc-viewer/files/demo.pdf`" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal><img src="@/assets/images/layouts/page-4/pdf.png" class="img-fluid" alt="image1"></a>         
                                </div>
                                <h6>Books.pdf</h6>            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <div class="mb-4 text-center p-3 rounded iq-thumb">
                                    <div class="iq-image-overlay"></div>
                                    <a href="#" data-title="Media.docx" :data-url="`${this.baseUrl}/doc-viewer/files/demo.docx`" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal ><img src="@/assets/images/layouts/page-4/doc.png" class="img-fluid" alt="image1"></a>
                                </div>
                                <h6>Media.docx</h6>     
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <div class="mb-4 text-center p-3 rounded iq-thumb">
                                    <div class="iq-image-overlay"></div>
                                    <a href="#" data-title="Flavours.xlsx" :data-url="`${this.baseUrl}/doc-viewer/files/demo.xlsx`" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal ><img src="@/assets/images/layouts/page-4/xlsx.png" class="img-fluid" alt="image1"></a>
                                </div>
                                <h6>Flavours.xlsx</h6> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body image-thumb">
                                <div class="mb-4 text-center p-3 rounded iq-thumb">
                                    <div class="iq-image-overlay"></div>
                                    <a href="#" data-title="Company.pptx" :data-url="`${this.baseUrl}/doc-viewer/files/demo.pptx`" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal><img src="@/assets/images/layouts/page-4/ppt.png" class="img-fluid" alt="image1"></a>           
                                </div>
                                <h6>Company.pptx</h6>          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="icon i-list">
                <div class="row">
                    <div class="col-lg-12">                        
                        <div class="card card-block card-stretch card-transparent">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <div class="header-title">
                                    <h4 class="card-title">list View</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card card-block card-stretch card-height">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless tbl-server-info">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Owner</th>
                                            <th scope="col">Last Edit</th>
                                            <th scope="col">File Size</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(list,index) in lists" :key="index">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-3">
                                                        <a  href="#"><img :src="list.image" class="img-fluid avatar-30" alt="image1"></a>
                                                       
                                                    </div>
                                                    <template v-if="list.img">
                                                      {{list.name}}
                                                    </template>
                                                    <template v-else>
                                                      <a href="#" :data-title="list.name" :data-url="list.url" @click="$root.$emit('bv::show::modal', 'viewer-modal', $event.target)" v-b-modal.viewer-modal >
                                                        <span style="color:#535F6B;">{{list.name}}</span>
                                                       </a>
                                                    </template>
                                                </div>
                                            </td>
                                            <td>{{list.owner}}</td>
                                            <td>{{list.lastedit}}</td>
                                            <td>{{list.size}}</td>
                                            <td>
                                                <b-dropdown  id="dropdownMenuButton" right variant="none" data-toggle="dropdown">
                                                <template v-slot:button-content>
                                                    <i class="ri-more-fill"></i>
                                                </template>
                                                <b-dropdown-item><i class="ri-eye-fill mr-2"></i>{{ ('view') }}</b-dropdown-item>
                                                <b-dropdown-item><i class="ri-delete-bin-6-fill mr-2"></i>{{ ('delete') }}</b-dropdown-item>
                                                <b-dropdown-item><i class="ri-pencil-fill mr-2"></i>{{ ('edit') }}</b-dropdown-item>
                                                <b-dropdown-item><i class="ri-printer-fill mr-2"></i>{{ ('print') }}</b-dropdown-item>
                                                <b-dropdown-item><i class="ri-file-download-fill mr-2"></i>{{ ('download') }}</b-dropdown-item>
                                            </b-dropdown>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script lang="js">
export default {
    name:'IonicChatApp',
    data(){
        return{
            datas:[
                {
                    name:'Books.jpeg',
                    src:require('@/assets/images/layouts/page-4/01.png')
                },
                {
                    name:'PHP.png',
                    src:require('@/assets/images/layouts/page-4/02.png')
                },
                {
                    name:'Box.svg',
                    src:require('@/assets/images/layouts/page-4/03.png')
                },
                {
                    name:'backup.mp4',
                    src:require('@/assets/images/layouts/page-4/04.png')
                }
            ],
            data:true,
            lists:[
                {
                     img:true,
                    name:'Alexa.jpeg',
                    image:require('@/assets/images/layouts/page-4/01.png'),
                    owner:'me',
                    size:'02 MB',
                    lastedit:'jan 21, 2020 me'
                },
                 {
                      img:true,
                    name:'Alexa2.png',
                    image:require('@/assets/images/layouts/page-4/02.png'),
                    owner:'Poul Molive',
                    size:'64 MB',
                    lastedit:'jan 25, 2020 Poul Molive'
                },
                 {
                      img:true,
                    name:'Alexa3.svg',
                    image:require('@/assets/images/layouts/page-4/03.png'),
                    owner:'me',
                    size:'30 MB',
                    lastedit:'Mar 30, 2020 Gail Forcewind'
                },
                 {
                      img:true,
                    name:'Alexa4.eps',
                    image:require('@/assets/images/layouts/page-4/04.png'),
                    owner:'me',
                    size:'10 MB',
                    lastedit:'Mar 30, 2020 Gail Forcewind'
                },
                 {
                      img:false,
                    url: this.baseUrl+'/doc-viewer/files/demo.pdf',
                    name:'Alexa5.pdf',
                    image:require('@/assets/images/layouts/page-4/pdf.png'),
                    owner:'me',
                    size:'10 MB',
                    lastedit:'Mar 30, 2020 Gail Forcewind'
                },
                 {
                      img:false,
                     url: this.baseUrl+'/doc-viewer/files/demo.docx',
                    name:'Alexa6.docx',
                    image:require('@/assets/images/layouts/page-4/doc.png'),
                    owner:'Penny',
                    size:'65 MB',
                    lastedit:'Mar 31, 2020 Penny'
                },
                 {
                       img:false,
                     url: this.baseUrl+'/doc-viewer/files/demo.xlsx',
                    name:'Alexa8.xlsx',
                    image:require('@/assets/images/layouts/page-4/xlsx.png'),
                    owner:'Banny',
                    size:'90 MB',
                    lastedit:'Mar 30, 2020 Banny'
                },
                 {
                       img:false,
                     url: this.baseUrl+'/doc-viewer/files/demo.pptx',
                    name:'Alexa7.pptx',
                    image:require('@/assets/images/layouts/page-4/ppt.png'),
                    owner:'me',
                    size:'10 MB',
                    lastedit:'Apr 04, 2020 me'
                }
            ]
        }
    },
    methods:{
       change(){
            this.data = !this.data
       }
   }
}
</script>