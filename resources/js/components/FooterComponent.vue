
<script>
export default {
  data: () => ({
    icons: [
      {
        icon: "mdi-linkedin",
        url: "https://www.linkedin.com/in/miguel-p%C3%A9rez-monsalve-20a67b50/",
      },
      {
        icon: "mdi-github",
        url: "https://github.com/migperezm/dancing-with-death",
      },
      {
        icon: "mdi-gmail",
        url: "https://mail.google.com/mail/?view=cm&source=mailto&to=mig.perezm@gmail.com",
      },
    ],
  }),
};
</script>
<template>
  <v-footer app bottom fixed padless>
    <v-card class="flex" flat tile>
      <v-card-title class="teal">
        <strong class="subheading">Contáctame</strong>
        <v-spacer></v-spacer>
        <v-btn
          v-for="icon in icons"
          :key="icon.icon"
          class="mx-4"
          icon
          :href="icon.url"
          target="_blank"
        >
          <v-icon size="24px">
            {{ icon.icon }}
          </v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text class="py-2 white--text text-center">
        {{ new Date().getFullYear() }} — <strong>Miguel Pérez Monsalve</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>