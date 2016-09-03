@extends('layouts.home')
@section('info')
    <title>{{Config::get('web.web_title')}}-{{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="{{Config::get('web.web_keywords')}}"/>
    <meta name="description" content="{{Config::get('web.web_description')}}"/>
@endsection
@section('content')

    <div class="banner">
        <section class="box">
            <ul class="texts">
                <p>一张网页，要经历怎样的历程，才能抵达用户面前？</p>
                <p>一个程序，要经历多少的日夜，才能运行各个平台？</p>
                <p>一位新人，要经历怎样的成长，才能站在技术之巅？</p>
                <p>我是刘强，一个在技术底层滚爬的新人</p>
            </ul>
            <div class="avatar"><a href="#"><span>刘强</span></a></div>
        </section>
    </div>
    <div class="template">
        <div class="box">
            <h3>
                <p><span>站长推荐</span>Recommend</p>
            </h3>
            <ul>
                @foreach($pics as $p)
                    <li><a href="{{url('a/'.$p->art_id)}}" target="_blank"><img
                                    src="{{url($p->art_thumb)}}"></a><span>{{$p->art_title}}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <article>
        <h2 class="title_tj">
            <p>文章<span>推荐</span></p>
        </h2>
        <div class="bloglist left">
            @foreach($data  as $d)
                <h3>{{$d->art_title}}</h3>
                <figure><img style="height: 150px;" src="{{url($d->art_thumb)}}"></figure>
                <ul>
                    <p>{{$d->art_description}}</p>
                    <a title="{{$d->art_description}}" href="{{url('a/'.$d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <p class="dateview"><span>{{date('Y-m-d',$d->art_time)}}</span><span>{{$d->art_editor}}</span></p>
            @endforeach
            <div class="page">
                {{$data->links()}}
            </div>
        </div>
        <aside class="right"  style="float:left;" >

            <div class="news">
                @parent
                <h3 class="links">
                    <p>友情<span>链接</span></p>
                </h3>
                <ul class="website">
                    @foreach($links as $l)
                        <li><a href="{{$l->link_url}}" target="_blank">{{$l->link_name}}</a></li>
                    @endforeach
                </ul>
            </div>

        </aside>
    </article>
@endsection