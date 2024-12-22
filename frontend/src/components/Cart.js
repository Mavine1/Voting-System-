import "./cart.css";
import React, { useEffect, useState } from "react";
import axios from "../api";
import { useCartContext } from "../store/CartProvider";
const Cart = () => {
  const { cartItems, setCartItems,getCartItems } = useCartContext();

  const cartItemsWithSubtotal = cartItems.map((item) => ({
    ...item,
    subtotal: parseFloat(item.price) * parseInt(item.quantity), // Subtotal = price * quantity
  }));

  const cartItemsTotal = cartItemsWithSubtotal.reduce(
    (total, item) => total + item.subtotal,
    0
  ).toFixed(2);

  const orderItems = cartItemsWithSubtotal
    .map(
      (item) => `${item.name} - ${item.quantity} @ ${item.price}` // Example: "galaxy s23->2 @ 1000"
    )
    .join(", ");



  const placeOrder = () => {
    axios
      .post("/orders", { items: orderItems, total_price:cartItemsTotal })
      .then((response) => {
        console.log(response);
        setCartItems([])
      })
      .catch((error) => console.log(error));
  };

  const removeItem = async (productId) => {
    console.log(productId,cartItems);
    
    axios
      .delete("/cart/remove", {data:{product_id:productId}})
      .then(() => {
        alert("Item Removed")
        getCartItems();
      })
      .catch((error) => console.log(error));
  };

  return (
    <div style={styles.container}>
      <h2 className="section_title">Shopping Cart</h2>

      <div className="main-cart">
        <div className="main-cart-header">
          <div className="title">My Cart</div>
          <div className="cart-count">{cartItems?.length} item(s)</div>
        </div>

        <div className="main-cart-body">
          <table>
            <thead>
              <tr>
                <th>Product</th>
                <th>Display</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Sub Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {cartItems?.length ? (
                cartItemsWithSubtotal?.map((item, idx) => (
                  <tr key={idx}>
                    <td>{item.name}</td>
                    <td>
                      <img src={item.display_image} alt={item.display} />
                    </td>
                    <td>{item.quantity}</td>
                    <td>{item.price}</td>
                    <td>{item?.subtotal}</td>
                    <td>
                      <button
                        className="remove-btn"
                        onClick={() => removeItem(item.product_id)}
                      >
                        Remove
                      </button>
                    </td>
                  </tr>
                ))
              ) : (
                <p>Your Cart is Empty 😞</p>
              )}
              <tr></tr>
            </tbody>
          </table>
        </div>
        <div className="main-cart-footer">
          <h3 className="total_summary">Total:</h3>
          <p className="total_summary_amount">$ {cartItemsTotal} </p>
          <button className="btn product_btn cart-btn" onClick={placeOrder}>
            {" "}
            Place Order{" "}
          </button>
        </div>
      </div>
    </div>
  );
};

const styles = {
  container: { padding: "20px" },
  cartList: { display: "flex", flexWrap: "wrap", gap: "20px" },
  cartItem: {
    border: "1px solid #ccc",
    padding: "10px",
    width: "200px",
    textAlign: "center",
  },
};

export default Cart;
