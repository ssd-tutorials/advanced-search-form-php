<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advanced Search Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href="./assets/css/dist/app.css" rel="stylesheet">
</head>
<body>

    <div class="row">

        <div class="column">

            <form
                method="get"
                action="/"
                class="panel"
                >

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns">
                        <label for="keyword">Search for:</label>
                        <input
                            type="text"
                            name="keyword"
                            id="keyword"
                            >
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="category">Category:</label>
                        <select
                            name="category"
                            id="category"
                            >
                            <option value="">Any category</option>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="author">Author:</label>
                        <select
                            name="author"
                            id="author"
                        >
                            <option value="">Any author</option>
                        </select>
                    </div>

                </div>

                <div class="divider brtd"></div>

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns">
                        <label for="year">Year:</label>
                        <select
                            name="year"
                            id="year"
                        >
                            <option value="">Any year</option>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label for="language">Language:</label>
                        <select
                            name="language"
                            id="language"
                        >
                            <option value="">Any language</option>
                        </select>
                    </div>
                    <div class="large-4 medium-6 small-12 columns">
                        <label>Cover type:</label>
                        <ul class="inline-list">
                            <li>
                                <label for="cover_0">
                                    <input
                                        type="radio"
                                        name="cover"
                                        id="cover_0"
                                        value=""
                                        > Any
                                </label>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="divider brtd"></div>

                <label>Available in:</label>

                <ul class="inline-list">
                        <li>
                            <label for="location_1">
                                <input
                                    type="checkbox"
                                    name="location[]"
                                    id="location_1"
                                    value="1"
                                > Option
                            </label>
                        </li>
                </ul>

                <div class="divider brtd"></div>

                <div class="row">

                    <div class="large-4 medium-6 small-12 columns large-offset-4 medium-offset-3">

                        <div class="expanded button-group">
                        <a
                            href="/"
                            class="alert button"
                        ><i class="fa fa-times"></i> RESET</a>
                        <input
                            type="submit"
                            class="button"
                            value="SEARCH"
                            >
                        </div>

                    </div>

                </div>

            </form>

            <table class="table-list">
                <thead>
                    <tr>
                        <th>
                            <i class="fa fa-book"></i> Books
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Title<br />
                            <small>
                                <strong>Author(s):</strong> <br />
                                <strong>Year:</strong> , <strong>Price:</strong> <br />
                                <strong>Category:</strong> , <strong>Cover types:</strong> <br />
                                <strong>Available in:</strong> , <strong>Languages:</strong>
                            </small>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>

<script src="./assets/js/dist/app.js"></script>
</body>
</html>