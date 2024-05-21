<script>

export default {
  props: {
    video: String,
  },
};

</script>

<template>
  <iframe width="1280" height="720" :src="video" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</template>

<style scoped>
iframe {
  width: 1580px;
  height: 680px;
}
</style>
