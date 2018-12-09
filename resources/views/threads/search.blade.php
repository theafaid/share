@extends('layouts.app')

@section("title")
    {{$title}}
@endsection

@section('content')

    <template>
        <ais-index
                app-id="{{config('services.algolia.id')}}"
                api-key="{{config('services.algolia.key')}}"
                index-name="threads"
                query="{{request('q')}}"
        >

    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <h1 class="text-white mb-20"> {{$title}} </h1>
                </div>
            </div>
        </div>
    </section>
    <!-- End top-section Area -->

    <!-- Start post Area -->
    <div class="post-wrapper pt-100">
        <!-- Start post Area -->
        <section class="post-area">
            <div class="container">
                <div class="row justify-content-center d-flex">
                            <div class="col-lg-8">
                                <div class="post-lists">

                                    <ais-results>
                                        <template scope="{ result }">
                                            <a :href="result.path">
                                                <div class="card-header" v-text="result.title">
                                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                                </div>
                                            </a>
                                        </template>
                                    </ais-results>

                                    <ais-no-results>
                                        <template slot-scope="props">
                                            <div class="alert alert-warning">
                                                No Threads found for <span class="badge badge-dark">@{{ props.query }}.</span>
                                            </div>
                                        </template>
                                    </ais-no-results>
                                </div>
                            </div>

                            <div class="col-lg-4 sidebar-area">
                                <div class="single_widget search_widget">
                                    <div id="imaginary_container">
                                        <div class="input-group stylish-input-group">
                                            <ais-search-box class="form-control">
                                                <ais-input placeholder="Search for a thread ..." :autofocus="true"></ais-input>
                                            </ais-search-box>
                                        </div>
                                    </div>
                                </div>

                                <div class="single_widget cat_widget">
                                    <h4 class="text-uppercase pb-20">Search by a channel</h4>
                                    <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                                </div>

                                <div class="single_widget cat_widget">
                                    <h4 class="text-uppercase pb-20">Trending Threads</h4>
                                    <ul>
                                        @forelse($trending as $thread)
                                            <li>
                                                <a href="{{$thread->link}}">{{$thread->title}}</a>
                                            </li>
                                        @empty
                                            <div class="alert alert-warning">No Trending Threads</div>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                </div>
            </div>
        </section>
        <!-- End post Area -->
    </div>
    <!-- End post Area -->

        </ais-index>
    </template>
@endsection