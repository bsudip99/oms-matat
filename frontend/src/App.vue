<template>
  <div id="app">
    <header> 
      <h1>Order Management System</h1>
    </header>
    <main>
      <OrderTableList />
    </main>
    <footer>
      <p>&copy; 2024 Order Management System</p>
    </footer>
  </div>
</template>

<script>
import OrderTableList from './components/OrderTableList.vue';

export default {
  components: {
    OrderTableList,
  },
};
</script>

<style scoped>
#app {
  font-family: Arial, sans-serif;
  margin: 0 auto;
  max-width: 960px;
  padding: 20px;
}

header {
  background-color: #333;
  color: #fff;
  padding: 10px 0;
  text-align: center;
}

header h1 {
  margin: 0;
}

main {
  margin-top: 20px;
}

footer {
  margin-top: 20px;
  text-align: center;
}
</style>
