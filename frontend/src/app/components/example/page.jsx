"use client"

import { useState } from "react"
import { Checkbox } from "@/components/ui/checkbox"
import { DataTable } from "@/components/data-table/data-table"
import { DataTableColumnHeader } from "@/components/data-table/data-table-column-header"
import { DataTableRowActions } from "@/components/data-table/data-table-row-actions"
import { useToast } from "@/hooks/use-toast"

// Sample data
const data = [
  {
    id: "1",
    name: "John Doe",
    email: "john@example.com",
    role: "Admin",
    status: "active",
  },
  {
    id: "2",
    name: "Jane Smith",
    email: "jane@example.com",
    role: "User",
    status: "active",
  },
  {
    id: "3",
    name: "Bob Johnson",
    email: "bob@example.com",
    role: "Editor",
    status: "inactive",
  },
  {
    id: "4",
    name: "Alice Brown",
    email: "alice@example.com",
    role: "User",
    status: "active",
  },
  {
    id: "5",
    name: "Charlie Wilson",
    email: "charlie@example.com",
    role: "User",
    status: "inactive",
  },
  {
    id: "6",
    name: "Diana Miller",
    email: "diana@example.com",
    role: "Editor",
    status: "active",
  },
  {
    id: "7",
    name: "Edward Davis",
    email: "edward@example.com",
    role: "Admin",
    status: "active",
  },
  {
    id: "8",
    name: "Fiona Garcia",
    email: "fiona@example.com",
    role: "User",
    status: "inactive",
  },
  {
    id: "9",
    name: "George Martinez",
    email: "george@example.com",
    role: "User",
    status: "active",
  },
  {
    id: "10",
    name: "Hannah Robinson",
    email: "hannah@example.com",
    role: "Editor",
    status: "active",
  },
  {
    id: "11",
    name: "Ian Clark",
    email: "ian@example.com",
    role: "User",
    status: "inactive",
  },
  {
    id: "12",
    name: "Julia Lewis",
    email: "julia@example.com",
    role: "Admin",
    status: "active",
  },
]

export default function UsersPage() {
  const { toast } = useToast()
  const [users, setUsers] = useState(data)

  // Handle edit user
  const handleEditUser = (user) => {
    toast({
      title: "Edit User",
      description: `Editing user: ${user.name}`,
    })
    // In a real app, you would open a modal or navigate to an edit page
  }

  // Handle delete user
  const handleDeleteUser = (user) => {
    toast({
      title: "Delete User",
      description: `Deleting user: ${user.name}`,
    })
    // In a real app, you would show a confirmation dialog and then delete
    setUsers(users.filter((u) => u.id !== user.id))
  }

  // Define columns
  const columns = [
    {
      id: "select",
      header: ({ table }) => (
        <Checkbox
          checked={table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && "indeterminate")}
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
          aria-label="Select all"
        />
      ),
      cell: ({ row }) => (
        <Checkbox
          checked={row.getIsSelected()}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
          aria-label="Select row"
        />
      ),
      enableSorting: false,
      enableHiding: false,
    },
    {
      accessorKey: "name",
      header: ({ column }) => <DataTableColumnHeader column={column} title="Name" />,
    },
    {
      accessorKey: "email",
      header: ({ column }) => <DataTableColumnHeader column={column} title="Email" />,
    },
    {
      accessorKey: "role",
      header: ({ column }) => <DataTableColumnHeader column={column} title="Role" />,
    },
    {
      accessorKey: "status",
      header: ({ column }) => <DataTableColumnHeader column={column} title="Status" />,
      cell: ({ row }) => {
        const status = row.getValue("status")
        return (
          <div className="flex items-center">
            <div className={`mr-2 h-2 w-2 rounded-full ${status === "active" ? "bg-green-500" : "bg-red-500"}`} />
            <span className="capitalize">{status}</span>
          </div>
        )
      },
    },
    {
      id: "actions",
      cell: ({ row }) => (
        <DataTableRowActions row={row} viewPath="/example/users" onEdit={handleEditUser} onDelete={handleDeleteUser} />
      ),
    },
  ]

  return (
    <div className="container mx-auto py-10">
      <h1 className="text-2xl font-bold mb-6">Users</h1>
      <DataTable columns={columns} data={users} filterColumn="name" />
    </div>
  )
}

