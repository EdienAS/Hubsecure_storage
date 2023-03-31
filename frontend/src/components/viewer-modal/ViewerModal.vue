<template>
    <b-modal style="height: 500px;" size="xl" id="viewer-modal" hide-footer :title="title">
      <div id="viewer-container"  style="height: 500px;" class="overflow-auto">No Data Found</div>
    </b-modal>
</template>

<script lang="js">
export default {
    name: 'ViewerModal',
    data () {
        return {
            url: '',
            title: ''
        }
    },
    watch: {
        url: function(value) {
            this.loadViewer(value)
        }
    },
    mounted () {
        this.$root.$on('bv::show::modal', (modalId, elem) => {
            let data = elem.dataset 
            this.url = data.url
            this.title = data.title
        })
        // this.$root.$on('bv::modal::hide', (bvEvent, modalId) => {
        //     this.resetViewer()
        // })
        this.$root.$on('bv::modal::hide', () => {
            this.resetViewer()
        })
    },
    methods: {
        resetViewer () {
            window.$('#viewer-container').html('')
        },
        loadViewer (url) {
            this.resetViewer()
            if (window.$.fn.officeToHtml !== undefined && url !== undefined) {
                window.$('#viewer-container').officeToHtml({
                    url: url,
                    pdfSetting: {
                        setLang: "",
                        setLangFilesPath: ""
                    }
                });
            }
        }
    },
    destroyed () {
        this.$off('bv::show::modal')
        this.$off('bv::modal::show')
        this.$off('bv::modal::hide')
    }
}
</script>
<style>
/* @import '../../assets/vendor/doc-viewer/include/officeToHtml/officeToHtml.css';
@import '../../assets/vendor/doc-viewer/include/pdf/pdf.viewer.css';
@import '../../assets/vendor/doc-viewer/include/PPTXjs/css/pptxjs.css';
@import '../../assets/vendor/doc-viewer/include/PPTXjs/css/nv.d3.min.css';
@import '../../assets/vendor/doc-viewer/include/SheetJS/handsontable.full.min.css';
@import '../../assets/vendor/doc-viewer/include/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css'; */
</style>