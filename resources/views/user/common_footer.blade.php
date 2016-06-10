<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <a href="" class="foo-logo hide">
                    <img alt="" src="images/logo.png">
                </a>
                <span class="copyright">&copy; Boatlah 2016. All Rights Reserved.</span>
            </div>
            <div class="col-sm-8">
                <div class="foo-nav">
                    <?php $allPages = \App\Pages::all();?>
                    @foreach($allPages as $allPage)
                    <a href="/pages/{{$allPage->url}}">{{$allPage->title}}</a>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- section-footer-bottom -->
</footer>