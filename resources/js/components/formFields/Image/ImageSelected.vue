<template>
  <div class="selected-library-item sfl-selected-item mb-5">
    <div class="card d-flex flex-row media-thumb-container">
      <a class="d-flex align-self-center">
        <img
          src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
          alt="uploaded image"
          class="list-media-thumbnail responsive border-0 sfl-selected-item-image"
        />
      </a>
      <div class="d-flex flex-grow-1 min-width-zero">
        <div
          class="card-body align-self-center d-flex flex-column justify-content-between min-width-zero align-items-lg-center"
        >
          <a class="w-100">
            <p
              class="list-item-heading mb-1 truncate sfl-selected-item-label"
            ></p>
          </a>
        </div>
        <div class="pl-1 align-self-center">
          <a href="#" class="btn-link delete-library-item sfl-delete-item"
            ><i class="simple-icon-trash"></i
          ></a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  setup() {},
};
</script>
