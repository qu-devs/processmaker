<template>
  <div class="carousel-container">
    <b-carousel
      id="processes-carousel"
      v-model="slide"
      no-animation
      :interval="interval"
      indicators
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
    >
      <b-carousel-slide
        v-for="(image, index) in images.length > 0 ? images : defaultImage"
        :key="index"
      >
        <template #img>
          <iframe
            v-if="image.type === 'embed'"
            class="d-block iframe-carousel"
            :src="image.url"
            title="embed media"
          />
          <img
            v-else
            :src="image.url"
            :alt="process.name"
            class="d-block img-carousel"
          >
        </template>
      </b-carousel-slide>
    </b-carousel>
  </div>
</template>

<script>
export default {
  props: {
    process: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      slide: 0,
      sliding: null,
      images: [],
      defaultImage: Array(4).fill({ url: "/img/launchpad-images/defaultImage.svg" }),
      interval: 0,
    };
  },
  mounted() {
    this.getLaunchpadImages();
    ProcessMaker.EventBus.$on("getLaunchpadImagesEvent", ({ indexImage, type }) => {
      if (type === "delete") {
        this.images.splice(indexImage, 1);
      } else {
        this.images = [];
        this.getLaunchpadImages();
      }
    });
  },
  methods: {
    onSlideStart(slide) {
      this.sliding = true;
    },
    onSlideEnd(slide) {
      this.sliding = false;
    },
    /**
     * Get images from Media library related to process.
     */
    getLaunchpadImages() {
      ProcessMaker.apiClient
        .get(`process_launchpad/${this.process.id}`)
        .then((response) => {
          const firstResponse = response.data.shift();
          const mediaArray = firstResponse.media;
          const embedArray = firstResponse.embed;
          mediaArray.forEach((media) => {
            const mediaType = media.custom_properties.type ?? "image";
            this.images.push({
              url: media.original_url,
              type: mediaType,
            });
          });
          embedArray.forEach((embed) => {
            const customProperties = JSON.parse(embed.custom_properties);
            this.images.push({
              url: customProperties.url,
              type: customProperties.type,
            });
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
<style lang="scss" scoped>
.carousel-inner {
  overflow: hidden;
}
.img-carousel {
  max-width: 800px;
  height: 410px;
  aspect-ratio: 16/9;
}
.iframe-carousel {
  border: 0px;
  width: 800px;
  height: 400px;
}
.carousel-container {
  display: flex;
  justify-content: center;
  border-radius: 16px;
  background-color: #edf1f6;
}
@media (width <= 1500px) {
  .img-carousel {
    max-width: 700px;
  }
}
@media (width <= 1366px) {
  .img-carousel {
    max-width: 590px;
  }
}
@media (width <= 1200px) {
  .img-carousel {
    max-width: 513px;
    height: auto;
  }
}
@media (width <= 992px) {
  .img-carousel {
    max-width: 486px;
    height: auto;
  }
}
</style>
