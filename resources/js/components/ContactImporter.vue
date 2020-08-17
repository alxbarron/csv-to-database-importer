<template>
    <div class="row">
        <div class="col-10 offset-1">
            <div class="section jumbotron text-center" v-show="welcome">
                <h1 class="title">Contact List CSV Importer</h1>
                <h2 class="subtitle">Laravel + Vue</h2>
                <p class="lead">Select a CSV file to import, then map the fields with the available options & import</p>
                <button @click="init" class="btn btn-primary btn-lg">Enter</button>
            </div>
            
            <transition name="fade">
                <ContactCsvUploader
                v-if="contactForm"/>
            </transition>
        </div>
    </div>
</template>

<script>
import ContactCsvUploader from './ContactCsvUploader.vue'

export default {
    name: 'ContactImporter',

    beforeMount ()  {
        this.welcome = true;
    },

    data: () => ({
        welcome: false,
        contactForm: false
    }),

    methods: {
        init () {
            this.welcome = false;
            this.contactForm = true;
        }
    },

    components: {
        ContactCsvUploader
    }
}
</script>

<style>

</style>