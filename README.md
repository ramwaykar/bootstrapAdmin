# bootstrapAdmin

<h5>Feature:</h5>
                <ul>
                    <li>Easy Installable</li>
                    <li>In-build user management</li>
                    <li>In-built role management</li>
                    <li>DB Log Management</li>
                    <li>Dynamic query generator</li>
                    <li>Descent UI</li>
                    <li>Responsive Design</li>
                    <li>Language localization. All labels are added in single file. So easy to modify</li>
                    <li>Both server side and client side validation added</li>
                    <li>Easy to understand and clean coding</li>
                    <li>Soft delete of records</li>
                </ul>
                <h5>Technologies Used:</h5>
                <ul>
                    <li>PHP</li>
                    <li>SQL</li>
                    <li>Bootstrap Js</li>
                    <li>MySql</li>
                    <li>Datatables</li>
                </ul>
                <h5>Configuration changes need to be done are:</h5>
                <ul>
                    <li>In 'commonFiles/conf.php' file change 'docRoot' and 'siteRoot' values</li>
                    <li>In 'static/js/common.js' file change 'domainUrl'</li>
                </ul>
                <h5>How to add new module? It’s very easy, just follow the following steps</h5>
                <ul>
                    <li>Add new folder in ‘views/myModule’</li>
                        <ul>
                            <li>index.php</li>
                            <li>modConf.php </li>
                            <li>listView.php</li>
                        </ul>
                    <li>Add new file in ‘ validations/validateMyModule.php’ for server side validation</li>
                    <li>Add new file in ‘ models/myModule.php’ for DB operations</li>
                    <li>Add new file in ‘ controllers/myModuleBO.php’ for routing</li>
                    <li>Add new js file in ‘static/js/myModuleListView.js’ for JS functions</li>
                </ul>
