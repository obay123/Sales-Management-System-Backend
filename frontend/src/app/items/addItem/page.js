"use client";

import useItemsApi from "@/api/ItemsApi";
import { useState } from "react";

const AddItem = () => {
  const { addItem } = useItemsApi();
  const [item, setItem] = useState({ code: "", name: "", description: "" });
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

  const handleChange = (e) => {
    setItem((prev) => ({ ...prev, [e.target.name]: e.target.value }));
  };

  const handleAddItem = async (e) => {
    e.preventDefault();
    setError(null);
    setSuccess(null);

    try {
      await addItem(item);
      setSuccess("Item added successfully!");
      setItem({ code: "", name: "", description: "" });
    } catch (error) {
      setError(error.message || "Error adding item.");
    }
  };

  return (
    <form onSubmit={handleAddItem}>
      {error && <p style={{ color: "red" }}>{error}</p>}
      {success && <p style={{ color: "green" }}>{success}</p>}

      <input
        type="text"
        name="code"
        value={item.code}
        onChange={handleChange}
        placeholder="Code"
        required
      />
      <input
        type="text"
        name="name"
        value={item.name}
        onChange={handleChange}
        placeholder="Item Name"
        required
      />    
      <input
        type="text"
        name="description"
        value={item.description}
        onChange={handleChange}
        placeholder="Description"
        required
      />
      <button
        type="submit"
        disabled={!item.code || !item.name || !item.description}
      >
        Add Item
      </button>
    </form>
  );
};

export default AddItem;
