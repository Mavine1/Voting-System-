import axios from "../api";
import { createContext, useContext, useEffect, useState } from "react";


const CartContext = createContext()



const CartProvider = ({children}) => {


    const [cartItems,setCartItems] = useState([])


    useEffect(()=>{
        getCartItems()
    },[])


   const getCartItems = async () => {

        axios.get('/cart').then(response=>{
            
            setCartItems(response.data.items)
        }).catch(err=>{
            console.log(err)
        })
    }
    return <CartContext.Provider value={{cartItems,setCartItems,getCartItems}}>

        {children}

    </CartContext.Provider>

    
}

export const useCartContext = () => useContext(CartContext)

export default CartProvider

