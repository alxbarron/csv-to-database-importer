<template>
    <div class="wrapper">
    <transition-group>    
        <div class="section" :key="'csv-upload'" v-if="csv == null">
            <h2 class="title">Import CSV File</h2>
                <FileUpload
                    @fileUploaded="setFileToImport( $event )"/>
        </div>

        <div class="section"
            :key="'map-fields'"
            v-if="csv != null && complete == false">

            <h2 class="title">Field Mapper</h2>
            <form @submit.prevent="importRecords">
                <div class="form-row">

                    <ContactFieldMapper
                        v-for="(field, index) in fields"
                        :key="index"
                        :field_name="field"
                        :samples="data_sample"
                        @change="selectInputHandler( $event )"/>

                    <div class="col-12 tb-spacer">
                        <button class="btn btn-success center"
                            v-if="mapped_fields">Import Records</button>
                    </div>
                </div>
            </form>
        </div>
            
        <div class="over-layer" :key="'map-importing'" v-if="importing_records">
            <div class="over-layer__wrapper spinner"></div>
        </div>
        
        <div class="section jumbotron text-center" :key="'success'" v-if="complete">
                <h1 class="title">Contact List CSV Importer</h1>
                <h2 class="subtitle">Laravel + Vue</h2>
                <p class="lead">Select a CSV file to import, then map the fields with the available options & import</p>
                <a href="/" class="btn btn-primary btn-lg">Close</a>
        </div>
    </transition-group>
    </div>
</template>

<script>
import ContactFieldMapper from './ContactFieldMapper.vue';
import FileUpload from './FileUpload.vue';

export default {
    name: 'ContactCsvUploader',

    data: () => ({
        // file: null,
        // file_ext: /(\.csv)$/i,
        csv: null,
        fields: null,
        data_sample: null,
        selected: {
            options: {},
            csv_field: {},
            custom_attr: {}
        },
        mapped_fields: false,
        importing_records: false,
        complete: false,
    }),

    computed: {
        getFileInfo () {
            if ( this.file == null)
                return 'Select CSV file';
            
            return this.file.name + ' / ' + (this.file.size/1000) + ' kb';
        }
    },

    methods: {
        setFileToImport (data) {
            this.csv = data.csv_file;
            this.fields = data.fields;
            this.data_sample = data.content_sample;
        },
        importRecords () {
            this.importing_records = true;

            let _this = this,
                form_data = this.buildImportRequest(this);
            
            axios.put('/contact-importer', form_data)
                .then(function (res) {
                    _this.complete = true;
                })
                .catch(function (err) {
                    alert.log(err.response);
                })
                .then(function () { _this.importing_records = false; });

        },
        buildImportRequest (_this) {
            let fields_selected = Object.values(this.selected.options);

            this.data_sample[0].forEach((element, index) => {
                if ( fields_selected.indexOf(index) == -1 )
                    _this.selected.custom_attr[index] = element;
            });

            Object.keys(this.selected.options).forEach( element => {
                _this.selected.csv_field[_this.selected.options[element]] = element;
            });

            return { csv_file: this.csv, 
                     csv_field: this.selected.csv_field,
                     custom_attr: this.selected.custom_attr };
        },
        selectInputHandler (data) {
            this.selected.options[data.field] = data.index;

            if ( Object.values(this.selected.options).length == this.fields.length)
                this.mapped_fields = true;
        }
    },

    components: {
        FileUpload,
        ContactFieldMapper
    }
}
</script>

<style lang="scss">
.over-layer {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    top: 0;
    left: 0;
    &__wrapper {
        position: absolute;
        left: 50%;
        top: 50%;
        height:60px;
        width:60px;
        margin:0px auto;
        &.spinner {
            -webkit-animation: rotation .6s infinite linear;
            -moz-animation: rotation .6s infinite linear;
            -o-animation: rotation .6s infinite linear;
            animation: rotation .6s infinite linear;
            border-left:6px solid rgba(0,174,239,.15);
            border-right:6px solid rgba(0,174,239,.15);
            border-bottom:6px solid rgba(0,174,239,.15);
            border-top:6px solid rgba(0,174,239,.8);
            border-radius:100%;
        }
    }
}

@-webkit-keyframes rotation {
   from {-webkit-transform: rotate(0deg);}
   to {-webkit-transform: rotate(359deg);}
}
@-moz-keyframes rotation {
   from {-moz-transform: rotate(0deg);}
   to {-moz-transform: rotate(359deg);}
}
@-o-keyframes rotation {
   from {-o-transform: rotate(0deg);}
   to {-o-transform: rotate(359deg);}
}
@keyframes rotation {
   from {transform: rotate(0deg);}
   to {transform: rotate(359deg);}
}
</style>