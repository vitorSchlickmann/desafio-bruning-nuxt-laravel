export default defineNuxtConfig({
  css: ['@/assets/css/tailwind.css'],
  app: {
    head: {
      link: [
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap'
        }
      ]
    }
  }
})
