"use client";

import { useEffect, useState } from "react";
import useItemsApi from "@/api/ItemsApi";
import DataTable from "../components/data-table";

export default function Items() {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchItems = async () => {
      try {
        const { getItems } = useItemsApi();
        const data = await getItems();
        setItems(data.items.data);
      } catch (error) {
        console.error("Error fetching items");
      } finally {
        setLoading(false);
      }
    };
    fetchItems();
  }, []);

  console.log(items);

  return (
    <div className="main-div">
      <h1>Items Page</h1>
      <DataTable
        title="Items List" // ✅ Still available if needed
        data={items} // ✅ Pass pre-fetched data
        loading={loading} // ✅ Pass loading state
        columns={[
          { key: "code", label: "Code", sortable: true },
          { key: "name", label: "Item Name", sortable: true }, // "name" is the field, "Item Name" is UI label
          { key: "description", label: "Description" }, // No sorting

          // { key: "created_at", label: "Created At", sortable: true },
          // { key: "updated_at", label: "Updated At", sortable: true },
        ]}
        viewRoute="/items/view"
        editRoute="/items/edit"
      />
    </div>
  );
}
