import "./productList.css";
import React, { useEffect, useState } from "react";
import axios from "../api"; // Ensure this points to the correct Axios instance or import path.
import productImage from "../assets/tv.jpg";
import { useNavigate } from "react-router-dom";

import { useCartContext } from "../store/CartProvider";
const ProductList = () => {
  const [products, setProducts] = useState([]);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  const { getCartItems } = useCartContext();
  useEffect(() => {
    getProducts();
  }, []);

  const getProducts = async () => {
    // Fetch products when the component is mounted
    axios
      .get("/products")
      .then((response) => {
        setProducts(response.data.data); // Assuming the API response is an array of products
        setLoading(false);
      })
      .catch((err) => {
        console.log("Error fetching products:", err);
        setError("Failed to fetch products. Please try again later.");
        setLoading(false);
      });
  };
  const addToCart = (productId) => {
    axios
    .post("/cart", { product_id: productId, quantity: 1 })
    .then(() => {
      alert("Product added to cart!");
      return getCartItems(); // Fetch updated cart items after successful addition
    })
    .then(() => {
      navigate("/cart"); // Navigate only after the cart items are updated
    })
    .catch((err) => {
      console.error("Error adding product to cart:", err);
      alert("Failed to add product to cart. Please try again.");
    });
  };

  if (loading) {
    return <div>Loading products...</div>;
  }

  if (error) {
    return <div style={{ color: "red" }}>{error}</div>;
  }

  return (
    <div className="container">
      <h2 className="section_title">Available Products</h2>
      {products.length === 0 ? (
        <p>No products available at the moment.</p>
      ) : (
        <ul className="product_list">
          {products?.map((product) => (
            <li key={product.id} className="product_card">
              <img src={product.display_image} alt={product.name} />
              <div className="product_details">
                <h3>{product.name}</h3>
                <p className="price">
                  Price: ${parseFloat(product.price).toFixed(2)}
                </p>
                <button
                  className="btn product_btn"
                  onClick={() => addToCart(product.id)}
                >
                  Add to Cart
                </button>
              </div>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

// Styling for the component
const styles = {
  container: { padding: "20px" },
  productList: {
    display: "flex",
    flexWrap: "wrap",
    gap: "20px",
    listStyle: "none",
    padding: 0,
  },
};

export default ProductList;
