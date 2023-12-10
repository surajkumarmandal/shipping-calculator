<!-- Design Shipping Calculator Form Template -->
<div class="custom-form-container">
    <form class="custom-form" method="post">

        <!-- First Column -->
        <div class="column">
            <label for="country">Country/Territory:</label>
            <select id="country" name="country">
                <!-- Populate with countries/territories -->
                <option value="us">United States</option>
                <option value="uk">United Kingdom</option>
                <!-- Add more options as needed -->
            </select>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="Enter your city" required>

            <label for="zipcode">Zipcode:</label>
            <input type="text" id="zipcode" name="zipcode" placeholder="Enter your zipcode" required>
        </div>

        <!-- Second Column -->
        <div class="column">
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Time</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows will be dynamically populated based on form selections -->
                    <tr>
                        <td>Service 1</td>
                        <td>2 hours</td>
                        <td>$50</td>
                    </tr>
                    <tr>
                        <td>Service 2</td>
                        <td>3 hours</td>
                        <td>$75</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>

        <input type="submit" value="Submit">
    </form>
</div>