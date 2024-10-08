export function saveCartToLocal(cart) {
  localStorage.setItem("cart", JSON.stringify(cart));
}

export function getCartFromLocal() {
  const cart = localStorage.getItem("cart");
  return cart ? JSON.parse(cart) : [];
}

export function clearCartFromLocal() {
  localStorage.removeItem("cart");
}
