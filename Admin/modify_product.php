<!-- modify_product.php -->
<div class="section">
    <h1 class="text-3xl font-bold mb-4">Modify Products</h1>
    <form>
        <div class="mb-4">
            <label class="block text-gray-700">Select Product</label>
            <select class="w-full p-2 border border-gray-300 rounded">
                <option value="">Select a product</option>
                <option value="product1">Product 1</option>
                <option value="product2">Product 2</option>
                <!-- Add more products as needed -->
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Stock Status</label>
            <select class="w-full p-2 border border-gray-300 rounded">
                <option value="in-stock">In Stock</option>
                <option value="out-of-stock">Out of Stock</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Apply Discount</label>
            <input type="text" placeholder="Enter discount percentage" class="w-full p-2 border border-gray-300 rounded">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Special Offers</label>
            <textarea placeholder="Enter any special offers or promotions" class="w-full p-2 border border-gray-300 rounded"></textarea>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Product
            </button>
        </div>
    </form>
</div>
