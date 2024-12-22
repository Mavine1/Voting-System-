import './order.css'
import React, { useEffect, useState } from 'react';
import axios from '../api';

const OrderHistory = () => {
    const [orders, setOrders] = useState([]);

    useEffect(() => {
        axios.get('/orders')
            .then(response => setOrders(response.data))
            .catch(err => console.error(err));
    }, []);

    return (
        <div style={styles.container}>
            <h2 className='section_title'>Your Orders</h2>


            <div className="orders-container">
        {orders.map((order) => (
          <div key={order.id} className="order-card">
            <h2>Order #{order.id}</h2>
            <p><strong>Items:</strong> {order.items}</p>
            <p><strong>Total Price:</strong> ${order.total_price}</p>
            <p><strong>Status:</strong> {order.status}</p>
            <p><strong>Placed On:</strong> {new Date(order.created_at).toLocaleString()}</p>
          </div>
        ))}
      </div>

        </div>
    );
};

const styles = {
    container: { padding: '20px' },
    orderList: { display: 'flex', flexWrap: 'wrap', gap: '20px' },
    orderCard: { border: '1px solid #ccc', padding: '10px', width: '200px', textAlign: 'center' },
};

export default OrderHistory;
