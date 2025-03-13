'use client'

import { useEffect, useState } from "react";
import useItemssApi from "@/api/ItemsApi";

export default function Items() {
  const [items, setItems] = useState([]);

  useEffect(() => {
    const fetchItems = async () => {
      try {
        const { getItems } = useItemssApi();
        const data = await getItems();
        setItems(data.items.data);
        console.log(data);
      } catch (error) {
        console.error("Error fetching items");
      }
    };
    fetchItems();
  }, []);

  console.log(items)
  

  return (
    <div className="main-div">
      <h1>Items Page</h1>
    </div>
  );
}
