<template>
    <div class="col-lg-4 col-md-6 col-xs-12 tb-spacer">
        <div class="data-sample">
            <h4 class="title">{{field_name}}</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{getHeader}}</li>
                <li class="list-group-item list-group-item-light"
                    v-for="(field_sample, index) in getSample"
                    :key="index"
                    v-text="field_sample"/>
            </ul>
        </div>
        <div class="data-map">
            <label :for="`${field_name}`"></label>
            <select class="form-control"
                :id="`${field_name}`"
                :name="`${field_name}`"
                v-model="value"
                @change="updateValue">
                <option 
                    disabled
                    value=""
                    v-text="disabledOption"/>
                <option
                    v-for="(val, pos) in samples[0]"
                    :key="pos"
                    :selected="field_name == val"
                    :value="{ index: pos, field: field_name }"
                    v-text="val"/>
            </select>
        </div> 
    </div>
</template>

<script>
export default {
    name: 'contact-field-mapper',

    props: {
        disabledOption: {
            type: String,
            default: 'Select one field to map'
        },
        samples: {
            type: Array,
            required: true,
        },
        field_name: {
            type: String,
            required: true,
        }
    },

    data: () => ({
        value: '',
        sample: null
    }),

    mounted: function() {
        this.$nextTick(function () {
            let exist = this.samples[0].indexOf(this.field_name);
            if ( exist != -1 ) {
                this.value = { index: exist, field: this.field_name };
                this.sample = exist;
                this.$emit('change', this.value);
            }
        })
    },

    computed: {
        getHeader () {
            if ( this.sample == null )
                return 'CSV Header';
            return this.samples[0][this.sample];
        },
        getSample () {
            if ( this.samples.length < 3 || this.sample == null)
                return ['Row1 value', 'Row2 value'];
            
            return [ this.samples[1][this.sample], this.samples[2][this.sample] ];
        }
    },

    methods: {
        updateValue (e) {
            this.sample = this.value.index;
            if ( this.value.index && this.value.field)
                this.$emit('change', this.value);
        }
    }

}
</script>

<style lang="scss">
.col-md-4 { margin: 15px 0px; }
</style>