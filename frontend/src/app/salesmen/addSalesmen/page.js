"use client";

import useSalesmenApi from "@/api/SalesmenApi";
import { useState } from "react";

const AddSalesman = () => {
    const { addSalesmen } = useSalesmenApi();
    const [salesman, setSalesman] = useState({ 
        code: "", 
        name: "", 
        phone: "", 
        address: "", 
        is_inactive: false 
    });

    const handleAddSalesman = async (e) => {
        e.preventDefault();
        try {
            await addSalesmen(salesman);
            console.log("Salesman added successfully");
            setSalesman({ code: "", name: "", phone: "", address: "", is_inactive: false }); 
        } catch (error) {
            console.error("Error adding salesman:", error);
        }
    };

    return (
        <form onSubmit={handleAddSalesman}>
            <input 
                type="text" 
                value={salesman.code} 
                onChange={(e) => setSalesman(prev => ({ ...prev, code: e.target.value }))} 
                placeholder="Code" 
                required 
            />
            <input 
                type="text" 
                value={salesman.name} 
                onChange={(e) => setSalesman(prev => ({ ...prev, name: e.target.value }))} 
                placeholder="Salesman Name" 
                required 
            />
            <input 
                type="text" 
                value={salesman.phone} 
                onChange={(e) => setSalesman(prev => ({ ...prev, phone: e.target.value }))} 
                placeholder="Phone Number" 
                required 
            />
            <input      
                type="text" 
                value={salesman.address} 
                onChange={(e) => setSalesman(prev => ({ ...prev, address: e.target.value }))} 
                placeholder="Address" 
                required 
            />
            <label>
                <input 
                    type="checkbox" 
                    checked={salesman.is_inactive} 
                    onChange={(e) => setSalesman(prev => ({ ...prev, is_inactive: e.target.checked }))} 
                />
                Inactive
            </label>
           
            <button type="submit">Add Salesman</button>
        </form>
    );
};

export default AddSalesman;
