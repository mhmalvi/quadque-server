<template>
  <div>
    <ul class="pagination">
      <li class="page-item">
        <a
          class="page-link"
          href="#"
          @click="page_to(pagination.current_page - 1)"
          tabindex="-1"
          >Previous</a
        >
      </li>
      <li
        v-for="(data, index) in pages"
        :key="index"
        :class="pagination.current_page === index ? 'active' : ''"
      >
        <a
          v-if="index!==0"
          @click="page_to(index)"
          class="page-link"
          href="#"
          >{{ index }}</a
        >
      </li>
      <li class="page-item" v-if="pagination.current_page !== pages - 1">
        <a
          @click="page_to(pagination.current_page + 1)"
          class="page-link"
          href="#"
          >Next</a
        >
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      total: "",
      pages: "",
    };
  },
  props: ["pagination", "offset"],
  methods: {
    index() {
      console.log("pagination", this.pagination.current_page);
      console.log("offset", this.offset);
    },

    fetchAll() {
      axios
        .get(`/admin/products`)
        .then((response) => {
          this.total = response.data.total;
          this.lists = response.data;

          this.total = this.lists.total;
          this.pages = Math.floor(this.total / 5);
          console.log(this.pages);
        })
        .catch((error) => {});
    },

    page_to(index) {
      console.log(index);
      this.pagination.current_page = index;
      this.$emit("paginate");
    },
  },
  mounted() {
    this.index();
    this.fetchAll();
  },
};
</script>