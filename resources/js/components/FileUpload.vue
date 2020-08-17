<template>
<form @submit.prevent="uploadFile" enctype="multipart/form-data">
    <div class="form-row">
        <div class="col-8 offset-1">
            <div class="custom-file">
                <input type="file" class="custom-file-input form-control" id="csv-file" @change="selectFile">
                <label for="csv-file" class="custom-file-label">{{getFileInfo}}</label>
                <div class="invalid-feedback">{{errorMsg}}</div>
                <div class="valid-feedback">{{successMsg}}</div>
            </div>
        </div>
        <div class="col-2">
            <button class="btn btn-info" :disabled="isDisabled">Upload</button>
        </div>
    </div>
</form>
</template>

<script>
export default {
    name: 'FileUpload',

    props: {
        successMsg: {
            type: String,
            default: 'Awesome, you selected valid CSV file',
        },
        errorMsg: {
            type: String,
            default: 'Sorry, select a valid CSV file between 1kb - 200kb file size',
        },
    },

    data: () => ({
        file: null,
        file_ext: /(\.csv)$/i,
        valid_file: false,
    }),

    computed: {
        isDisabled () {
            return !this.valid_file;
        },
        getFileInfo () {
            if ( this.file == null)
                return 'Select CSV file';
            
            return this.file.name + ' / ' + (this.file.size/1000) + ' kb';
        }
    },

    methods: {
        selectFile (event) {
            let elem = event.target;
            if ( this.validateFile(elem, this.file_ext) ) {
                this.valid_file = true;console.log(elem.files[0]);
                this.file = elem.files[0];
                // this.$emit('change', this.file);
            }
        },
        validateFile (element, allowedExtensions) {
            if ( !allowedExtensions.exec(element.value) || element.files[0].size > 200000 || element.files[0].size < 1000 ){
                element.classList.add('is-invalid');
                element.classList.remove('is-valid');
                return false;
            }
            else {
                element.classList.add('is-valid');   
                element.classList.remove('is-invalid');
                return true;
            } 
        },
        uploadFile () {
            let _this = this,
                data = new FormData();
            data.append('csv-file', this.file);
            axios.post('/contact-importer', data)
                .then(function (res) {
                    _this.uploadSuccess(res.data.data);
                })
                .catch(function (err) {
                    _this.file = null;
                    _this.resetForm();
                    alert(err.response);
                });
        },
        uploadSuccess (data) {console.log(data);
            this.$emit('fileUploaded', data);
        },
        resetForm () {
            let form = document.querySelector('form'),
                input = form.querySelector('input');
            input.classList.remove('is-invalid');
            form.reset();
        }
    }
}
</script>

<style>

</style>