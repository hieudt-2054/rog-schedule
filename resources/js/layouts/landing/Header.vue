<template>
  <div class="main-layout">
    <navbar />
    <div class="container mt-4">
      <child />
      <h1>Hello World</h1>
    </div>
  </div>
</template>

<script>
export default {
    data () {
        return {
            title: 'Your Logo',
        }
    },
}
</script>
