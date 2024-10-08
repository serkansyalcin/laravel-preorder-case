import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import { saveCartToLocal, getCartFromLocal  } from '../utils/cart';

export const useCartStore = defineStore('cart', () => {
    const cart = ref(getCartFromLocal() || []);

  const totalItems = computed(() => {
    return cart.value.reduce((total, item) => total + item.quantity, 0);
  });
  const cartTotal = computed(() => {
    return cart.value.reduce((total, item) => total + item.price * item.quantity, 0);
  });

  function addToCart(item) {
    const existingItem = cart.value.find(i => i.id === item.id);
    if (existingItem) {
      existingItem.quantity += 1; // Increase quantity
    } else {
      cart.value.push({ ...item, quantity: 1 });
    }
    saveCartToLocal(cart.value);
  }

  function decreaseQty(item) {
    const existingItem = cart.value.find(i => i.id === item.id);
    if (existingItem) {
      if (existingItem.quantity > 1) {
        existingItem.quantity -= 1; // Decrease quantity
      } else {
        // Remove the item if quantity is zero
        cart.value = cart.value.filter(cartItem => cartItem.id !== item.id);
      }
      saveCartToLocal(cart.value);
    }
  }

  function clearCart() {
    cart.value = [];
    saveCartToLocal(cart.value);
  }

  function removeFromCart(item) {
    cart.value = cart.value.filter(cartItem => cartItem.id !== item.id);
    saveCartToLocal(cart.value);
  }

  

  function checkout() {
    // Here you would send the cart data to your Laravel API for processing
    console.log("Checkout with", cart.value);
  }

  return { cart, totalItems, cartTotal, removeFromCart, addToCart, decreaseQty, clearCart, checkout };
});
