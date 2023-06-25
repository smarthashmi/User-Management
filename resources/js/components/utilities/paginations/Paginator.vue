<template>
    <div>
      <nav aria-label="...">
        <ul class="pagination">
          <li class="page-item">
            <a href="" @click.prevent="getPreviousPage" class="page-link"><i class="fas fa-chevron-left"></i></a>
          </li>
          <li class="page-item">
            <a href="" @click.prevent="getNextPage" class="page-link"><i class="fas fa-chevron-right"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </template>

  <script>
  export default {
    methods: {
      getPreviousPage() {
        this.$emit('get-page', 'previous');
      },
      getNextPage() {
        this.$emit('get-page', 'next');
      }
    }
  };
  </script>
