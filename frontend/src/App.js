import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Navbar from './components/Navbar';
import ProductList from './components/ProductList';
import Cart from './components/Cart';
import OrderHistory from './components/OrderHistory';

const App = () => {
    return (
        <Router>
            <Navbar />
            <Routes>
                <Route path="/" element={<ProductList />} />
                <Route path="/cart" element={<Cart />} />
                <Route path="/orders" element={<OrderHistory />} />
            </Routes>
        </Router>
    );
};

export default App;
