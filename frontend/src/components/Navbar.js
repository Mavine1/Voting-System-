import React from 'react';
import { Link } from 'react-router-dom';

const Navbar = () => {
    return (
        <nav style={styles.navbar}>
            <div style={styles.logo}> ShopEasy</div>
            <ul style={styles.navLinks} className='nav-links'>
                <li><Link to="/cart">Cart</Link></li>
                <li><Link to="/orders">Orders</Link></li>
            </ul>
        </nav>
    );
};

const styles = {
    navbar: {
        display: 'flex',
        justifyContent: 'space-between',
        padding: '10px 20px',
        backgroundColor: '#0056b3',
        color: '#fff',
    },
    logo: { fontSize: '24px', fontWeight: 'bold' },
    navLinks: { display: 'flex', gap: '20px', listStyle: 'none' },
};

export default Navbar;
