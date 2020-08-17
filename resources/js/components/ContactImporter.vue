<template>
    <div class="row">
        <div class="col-10 offset-1">
        <transition-group>
            <JumbotronStep
                v-if="welcome"
                :key="'step-1'"
                @changeState="init( $event )"/>
            
            <ContactCsvUploader
                :key="'step-2'" v-if="contactForm"
                @importedFile="finish( $event )"/>
        
            <JumbotronStep
                :key="'step-3'" v-if="workDone"
                :subtitle="'Your CSV file was imported successfully !!!'"
                :content="'Tell me about what do you think or what would you do different.'"
                :action="'Find the code'"
                :link="'https://github.com/alxbastard/csv-to-database-importer'"/>
        </transition-group>
        </div>
    </div>
</template>

<script>
import ContactCsvUploader from './ContactCsvUploader.vue';
import JumbotronStep from './JumbotronStep.vue';

export default {
    name: 'ContactImporter',

    data: () => ({
        welcome: false,
        contactForm: false,
        workDone: false
    }),

    mounted ()  {
        this.welcome = true;
    },

    methods: {
        init (data) {
            this.welcome = false;
            this.contactForm = true;
        },
        finish (data){
            this.contactForm = !data;
            this.workDone = data;
        }
    },

    components: {
        JumbotronStep,
        ContactCsvUploader
    }
}
</script>

<style>

</style>