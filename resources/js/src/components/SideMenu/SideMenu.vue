<template>
  <div class="sidemenu-component-wrapping-div">
    <a href="#" class="side-menu-links">Users Management</a>
    <a href="#" class="side-menu-links">Order Management</a>
    <a href="#" class="side-menu-links">Scan QR code</a>
    <a href="#" class="side-menu-links">Import Excel File</a>
  </div>
</template>

<script>
export default {
  name: "SideMenu"
}
</script>

<style lang="scss" scoped>

@import '../../styles/styles.scss';

.sidemenu-component-wrapping-div {
  border: 1px solid $SIDEMENU_BORDER_COLOR;
  height: 500px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  // align-items: center;
}

.side-menu-links {
  height: 47px;
  // border: 1px solid $SIDEMENU_BORDER_COLOR;
  color: $SIDEMENU_LINKS_COLOR !important;
  display: flex;
  justify-content: center;
  align-items: center;

  &:hover {
    color: $SIDEMENU_LINKS_HOVER_COLOR !important;
    background-color: $SIDEMENU_LINKS_HOVER;
  }
}

</style>
