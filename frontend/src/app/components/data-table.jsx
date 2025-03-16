// "use client";

// import React, { useState, useEffect } from "react";
// import { useSearchParams, useRouter, usePathname } from "next/navigation";
// import {
//   ChevronLeft,
//   ChevronRight,
//   ChevronsLeft,
//   ChevronsRight,
//   Eye,
//   Search,
//   SortAsc,
//   SortDesc,
//   Edit,
//   Trash2,
//   Columns,
// } from "lucide-react";

// // import { Button } from "@/components/ui/button";
// import { Input } from "@/components/ui/input";
// import {
//   Table,
//   TableBody,
//   TableCell,
//   TableHead,
//   TableHeader,
//   TableRow,
// } from "@/components/ui/table";
// // import {
// //   Select,
// //   SelectContent,
// //   SelectItem,
// //   SelectTrigger,
// //   SelectValue,
// // } from "@/components/ui/select";
// import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
// import { Checkbox } from "@/components/ui/checkbox";
// // import {
// //   DropdownMenu,
// //   DropdownMenuContent,
// //   DropdownMenuLabel,
// //   DropdownMenuSeparator,
// //   DropdownMenuTrigger,
// //   DropdownMenuCheckboxItem,
// // } from "@/components/ui/dropdown-menu";
// // import {
// //   AlertDialog,
// //   AlertDialogAction,
// //   AlertDialogCancel,
// //   AlertDialogContent,
// //   AlertDialogDescription,
// //   AlertDialogFooter,
// //   AlertDialogHeader,
// //   AlertDialogTitle,
// // } from "@/components/ui/alert-dialog";

// const DataTable = ({
//   title,
//   endpoint,
//   columns,
//   viewRoute,
//   editRoute,
//   perPageOptions = [10, 25, 50, 100],
//   onDelete,
//   data: externalData,
//   loading: externalLoading,
// }) => {
//   const router = useRouter();
//   const pathname = usePathname();
//   const searchParams = useSearchParams();

//   const page = Number(searchParams.get("page") || "1");
//   const perPage = Number(
//     searchParams.get("per_page") || perPageOptions[0].toString()
//   );
//   const search = searchParams.get("search") || "";
//   const sortColumn = searchParams.get("sort") || columns[0].key;
//   const sortDirection = searchParams.get("direction") || "asc";

//   const [data, setData] = useState(externalData || []);
//   const [meta, setMeta] = useState({
//     total: 0,
//     per_page: perPage,
//     current_page: page,
//     last_page: 1,
//     from: 0,
//     to: 0,
//   });
//   const [loading, setLoading] = useState(externalLoading ?? true);
//   const [searchValue, setSearchValue] = useState(search);
//   const [selectedRows, setSelectedRows] = useState([]);
//   const [visibleColumns, setVisibleColumns] = useState(
//     columns.map((column) => column.key)
//   );
//   const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);

//   useEffect(() => {
//     if (!externalData && endpoint) {
//       fetchData();
//     }
//   }, [endpoint]);

//   useEffect(() => {
//     fetchData();
//   }, [endpoint, page, perPage, search, sortColumn, sortDirection]);

//   const fetchData = async () => {
//     setLoading(true);
//     try {
//       console.log(`Fetching data from: ${endpoint}`);

//       const response = await fetch(endpoint);

//       // Check if the response is an HTML document (error page)
//       const contentType = response.headers.get("content-type");
//       if (!contentType || !contentType.includes("application/json")) {
//         const errorText = await response.text(); // Get the full error message
//         throw new Error(`Unexpected response format: ${errorText}`);
//       }

//       const result = await response.json();
//       setData(result.data);
//     } catch (error) {
//       console.error("Error fetching data:", error);
//     } finally {
//       setLoading(false);
//     }
//   };

//   return (
//     <Card>
//       <CardHeader>
//         <CardTitle>{title}</CardTitle>
//       </CardHeader>
//       <CardContent>
//         <Table>
//           <TableHeader>
//             <TableRow>
//               {columns.map((column) => (
//                 <TableHead key={column.key}>{column.label}</TableHead>
//               ))}
//             </TableRow>
//           </TableHeader>
//           <TableBody>
//             {loading ? (
//               <TableRow>
//                 <TableCell colSpan={columns.length} className="text-center">
//                   Loading...
//                 </TableCell>
//               </TableRow>
//             ) : data.length === 0 ? (
//               <TableRow>
//                 <TableCell colSpan={columns.length} className="text-center">
//                   No items found.
//                 </TableCell>
//               </TableRow>
//             ) : (
//               data.map((row, index) => (
//                 <TableRow key={index}>
//                   {columns.map((column) => (
//                     <TableCell key={column.key}>
//                       {column.render
//                         ? column.render(row[column.key], row)
//                         : row[column.key]}
//                     </TableCell>
//                   ))}
//                 </TableRow>
//               ))
//             )}
//           </TableBody>
//         </Table>
//       </CardContent>
//     </Card>
//   );
// };

// export default DataTable;


// "use client";

// import React, { useState } from "react";
// import {
//   Table,
//   TableBody,
//   TableCell,
//   TableHead,
//   TableHeader,
//   TableRow,
// } from "@/components/ui/table";
// import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
// import { Button } from "@/components/ui/button";
// import { Checkbox } from "@/components/ui/checkbox";
// import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from "@/components/ui/dropdown-menu";
// import { Edit, Trash2, MoreVertical } from "lucide-react";

// const DataTable = ({
//   title,
//   columns,
//   data,
//   loading,
//   onUpdate, // ✅ Function to update item
//   onDelete, // ✅ Function to delete item
// }) => {
//   const [selectedRows, setSelectedRows] = useState([]);

//   // Toggle row selection
//   const handleSelectRow = (id) => {
//     setSelectedRows((prev) =>
//       prev.includes(id) ? prev.filter((rowId) => rowId !== id) : [...prev, id]
//     );
//   };

//   // Select All Rows
//   const handleSelectAll = () => {
//     if (selectedRows.length === data.length) {
//       setSelectedRows([]);
//     } else {
//       setSelectedRows(data.map((row) => row.id));
//     }
//   };

//   return (
//     <Card className="shadow-lg border border-gray-200">
//       <CardHeader className="flex justify-between items-center">
//         <CardTitle>{title}</CardTitle>
//         {selectedRows.length > 0 && (
//           <div className="flex gap-2">
//             <Button
//               variant="outline"
//               onClick={() => onUpdate(selectedRows)}
//               className="bg-blue-500 text-white hover:bg-blue-600"
//             >
//               Update Selected
//             </Button>
//             <Button
//               variant="destructive"
//               onClick={() => onDelete(selectedRows)}
//               className="bg-red-500 text-white hover:bg-red-600"
//             >
//               Delete Selected
//             </Button>
//           </div>
//         )}
//       </CardHeader>
//       <CardContent>
//         <Table className="w-full border border-gray-200">
//           <TableHeader>
//             <TableRow className="bg-gray-100">
//               <TableHead className="w-[50px] text-center">
//                 <Checkbox
//                   checked={selectedRows.length === data.length && data.length > 0}
//                   onCheckedChange={handleSelectAll}
//                 />
//               </TableHead>
//               {columns.map((column) => (
//                 <TableHead key={column.key} className="text-left">
//                   {column.label}
//                 </TableHead>
//               ))}
//               <TableHead className="text-right">Actions</TableHead>
//             </TableRow>
//           </TableHeader>
//           <TableBody>
//             {loading ? (
//               <TableRow>
//                 <TableCell colSpan={columns.length + 2} className="text-center py-4">
//                   Loading...
//                 </TableCell>
//               </TableRow>
//             ) : data.length === 0 ? (
//               <TableRow>
//                 <TableCell colSpan={columns.length + 2} className="text-center py-4">
//                   No items found.
//                 </TableCell>
//               </TableRow>
//             ) : (
//               data.map((row) => (
//                 <TableRow key={row.id} className="hover:bg-gray-50 transition-all">
//                   <TableCell className="text-center">
//                     <Checkbox
//                       checked={selectedRows.includes(row.id)}
//                       onCheckedChange={() => handleSelectRow(row.id)}
//                     />
//                   </TableCell>
//                   {columns.map((column) => (
//                     <TableCell key={column.key} className="py-2">
//                       {column.render
//                         ? column.render(row[column.key], row)
//                         : row[column.key]}
//                     </TableCell>
//                   ))}
//                   <TableCell className="text-right">
//                     <DropdownMenu>
//                       <DropdownMenuTrigger asChild>
//                         <Button variant="ghost" size="icon">
//                           <MoreVertical className="w-5 h-5" />
//                         </Button>
//                       </DropdownMenuTrigger>
//                       <DropdownMenuContent align="end">
//                         <DropdownMenuItem onClick={() => onUpdate(row.id)}>
//                           <Edit className="w-4 h-4 mr-2 text-blue-600" />
//                           Update
//                         </DropdownMenuItem>
//                         <DropdownMenuItem onClick={() => onDelete(row.id)} className="text-red-600">
//                           <Trash2 className="w-4 h-4 mr-2" />
//                           Delete
//                         </DropdownMenuItem>
//                       </DropdownMenuContent>
//                     </DropdownMenu>
//                   </TableCell>
//                 </TableRow>
//               ))
//             )}
//           </TableBody>
//         </Table>
//       </CardContent>
//     </Card>
//   );
// };

// export default DataTable;








"use client";

import { useState } from "react";
import { useSearchParams, useRouter, usePathname } from "next/navigation";
import {
  ChevronLeft,
  ChevronRight,
  ChevronsLeft,
  ChevronsRight,
  Eye,
  Search,
  SortAsc,
  SortDesc,
  Edit,
  Trash2,
  Columns,
} from "lucide-react";

import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
  DropdownMenuCheckboxItem,
} from "@/components/ui/dropdown-menu";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
  } from "@/components/ui/alert-dialog";
  

export default function DataTable({
  title,
  columns,
  data, // ✅ Receives pre-fetched data from Items.js
  loading, // ✅ Receives loading state from Items.js
  viewRoute,
  editRoute,
  perPageOptions = [10, 25, 50, 100],
  onDelete,
}) {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  // Get URL params with defaults
  const page = Number(searchParams.get("page") || "1");
  const perPage = Number(searchParams.get("per_page") || perPageOptions[0].toString());
  const search = searchParams.get("search") || "";
  const sortColumn = searchParams.get("sort") || columns[0].key;
  const sortDirection = searchParams.get("direction") || "asc";

  const [searchValue, setSearchValue] = useState(search);
  const [selectedRows, setSelectedRows] = useState([]);
  const [visibleColumns, setVisibleColumns] = useState(columns.map((column) => column.key));
  const [deleteDialogOpen, setDeleteDialogOpen] = useState(false);

  // Create URL with updated params
  const createQueryString = (params) => {
    const newSearchParams = new URLSearchParams(searchParams.toString());

    Object.entries(params).forEach(([key, value]) => {
      if (value === null) {
        newSearchParams.delete(key);
      } else {
        newSearchParams.set(key, value.toString());
      }
    });

    return newSearchParams.toString();
  };

  // Navigate with updated params
  const navigate = (params) => {
    router.push(`${pathname}?${createQueryString(params)}`);
  };

  // Handle sorting
  const handleSort = (column) => {
    const direction = column === sortColumn && sortDirection === "asc" ? "desc" : "asc";
    navigate({ sort: column, direction, page: 1 });
  };

  // Handle search
  const handleSearch = () => {
    navigate({ search: searchValue || null, page: 1 });
  };

  // Handle pagination
  const handlePageChange = (newPage) => {
    navigate({ page: newPage });
  };

  // Handle row selection
  const handleSelectRow = (id) => {
    setSelectedRows((prev) => (prev.includes(id) ? prev.filter((rowId) => rowId !== id) : [...prev, id]));
  };

  return (
    <Card>
      <CardHeader className="flex flex-col space-y-2 md:flex-row md:items-center md:justify-between md:space-y-0">
        <CardTitle>{title}</CardTitle>
        <div className="flex flex-col space-y-2 sm:flex-row sm:space-x-2 sm:space-y-0">
          <div className="relative">
            <Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
            <Input
              type="search"
              placeholder="Search..."
              className="w-full pl-8 md:w-[200px] lg:w-[300px]"
              value={searchValue}
              onChange={(e) => setSearchValue(e.target.value)}
              onKeyDown={(e) => e.key === "Enter" && handleSearch()}
            />
          </div>
          <Button size="sm" onClick={handleSearch}>
            Search
          </Button>
        </div>
      </CardHeader>
      <CardContent>
        <Table>
          <TableHeader>
            <TableRow>
              {columns.map((column) => (
                <TableHead key={column.key}>{column.label}</TableHead>
              ))}
            </TableRow>
          </TableHeader>
          <TableBody>
            {loading ? (
              <TableRow>
                <TableCell colSpan={columns.length} className="text-center">
                  Loading...
                </TableCell>
              </TableRow>
            ) : data.length === 0 ? (
              <TableRow>
                <TableCell colSpan={columns.length} className="text-center">
                  No items found.
                </TableCell>
              </TableRow>
            ) : (
              data.map((row, index) => (
                <TableRow key={index}>
                  {columns.map((column) => (
                    <TableCell key={column.key}>
                      {column.render ? column.render(row[column.key], row) : row[column.key]}
                    </TableCell>
                  ))}
                </TableRow>
              ))
            )}
          </TableBody>
        </Table>
      </CardContent>
    </Card>
  );
}


