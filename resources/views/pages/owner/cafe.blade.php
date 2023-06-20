@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-12">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="{{ asset($cafe->main_image) }}" height="100" style="object-fit: cover"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Kunjungan</div>
                                    <div class="profile-widget-item-value">{{ $cafe->visit->count() }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Ulasan</div>
                                    <div class="profile-widget-item-value">{{ $cafe->review->count() }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Rating</div>
                                    <div class="profile-widget-item-value">{{ $cafe->rating }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name text-dark font-weight-bold">
                                {{ $cafe->name }}
                            </div>
                            {{ $cafe->desc }}
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="mt-4 mb-3">
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/category') }}"
                            class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-boxes mr-1"></i> Kategori
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/image') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-image mr-1"></i> Foto
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/menu') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-hamburger mr-1"></i> Menu
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/url') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fab fa-tiktok mr-1"></i> Video Tiktok
                        </a>
                        <a href="{{ url('/owner/cafe/' . $cafe->id . '/review') }}" class=" btn btn-primary btn-icon mr-1">
                            <i class="fas fa-message mr-1"></i> Review
                        </a>
                    </div>
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate="">
                            <div class="card-header">
                                <h4>Edit Data Caffee</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6 col-12">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" value="Ujang" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the first name
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" value="Maman" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the last name
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-7 col-12">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="ujang@maman.com" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <div class="form-group col-md-5 col-12">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label>Bio</label>
                                        <textarea class="form-control summernote-simple" style="display: none;">Ujang maman is a superhero name in &lt;b&gt;Indonesia&lt;/b&gt;, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with &lt;b&gt;'John Doe'&lt;/b&gt;.</textarea>
                                        <div class="note-editor note-frame card">
                                            <div class="note-dropzone">
                                                <div class="note-dropzone-message"></div>
                                            </div>
                                            <div class="note-toolbar-wrapper" style="height: 72px;">
                                                <div class="note-toolbar card-header"
                                                    style="position: relative; top: 0px; width: 100%;">
                                                    <div class="note-btn-group btn-group note-style"><button type="button"
                                                            class="note-btn btn btn-light btn-sm note-btn-bold"
                                                            tabindex="-1" title=""
                                                            data-original-title="Bold (CTRL+B)"><i
                                                                class="note-icon-bold"></i></button><button type="button"
                                                            class="note-btn btn btn-light btn-sm note-btn-italic"
                                                            tabindex="-1" title=""
                                                            data-original-title="Italic (CTRL+I)"><i
                                                                class="note-icon-italic"></i></button><button type="button"
                                                            class="note-btn btn btn-light btn-sm note-btn-underline"
                                                            tabindex="-1" title=""
                                                            data-original-title="Underline (CTRL+U)"><i
                                                                class="note-icon-underline"></i></button><button
                                                            type="button" class="note-btn btn btn-light btn-sm"
                                                            tabindex="-1" title=""
                                                            data-original-title="Remove Font Style (CTRL+\)"><i
                                                                class="note-icon-eraser"></i></button></div>
                                                    <div class="note-btn-group btn-group note-font"><button type="button"
                                                            class="note-btn btn btn-light btn-sm note-btn-strikethrough"
                                                            tabindex="-1" title=""
                                                            data-original-title="Strikethrough (CTRL+SHIFT+S)"><i
                                                                class="note-icon-strikethrough"></i></button></div>
                                                    <div class="note-btn-group btn-group note-para">
                                                        <div class="note-btn-group btn-group"><button type="button"
                                                                class="note-btn btn btn-light btn-sm dropdown-toggle"
                                                                tabindex="-1" data-toggle="dropdown" title=""
                                                                data-original-title="Paragraph"><i
                                                                    class="note-icon-align-left"></i></button>
                                                            <div class="dropdown-menu">
                                                                <div class="note-btn-group btn-group note-align"><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Align left (CTRL+SHIFT+L)"><i
                                                                            class="note-icon-align-left"></i></button><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Align center (CTRL+SHIFT+E)"><i
                                                                            class="note-icon-align-center"></i></button><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Align right (CTRL+SHIFT+R)"><i
                                                                            class="note-icon-align-right"></i></button><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Justify full (CTRL+SHIFT+J)"><i
                                                                            class="note-icon-align-justify"></i></button>
                                                                </div>
                                                                <div class="note-btn-group btn-group note-list"><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Outdent (CTRL+[)"><i
                                                                            class="note-icon-align-outdent"></i></button><button
                                                                        type="button"
                                                                        class="note-btn btn btn-light btn-sm"
                                                                        tabindex="-1" title=""
                                                                        data-original-title="Indent (CTRL+])"><i
                                                                            class="note-icon-align-indent"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="note-editing-area">
                                                <div class="note-handle">
                                                    <div class="note-control-selection">
                                                        <div class="note-control-selection-bg"></div>
                                                        <div class="note-control-holder note-control-nw"></div>
                                                        <div class="note-control-holder note-control-ne"></div>
                                                        <div class="note-control-holder note-control-sw"></div>
                                                        <div class="note-control-sizing note-control-se"></div>
                                                        <div class="note-control-selection-info"></div>
                                                    </div>
                                                </div>
                                                <textarea class="note-codable"></textarea>
                                                <div class="note-editable card-block" contenteditable="true"
                                                    style="min-height: 150px;">Ujang maman is a superhero name in
                                                    <b>Indonesia</b>, especially in my family. He is not a fictional
                                                    character but an original hero in my family, a hero for his children and
                                                    for his wife. So, I use the name as a user in this template. Not a
                                                    tribute, I'm just bored with <b>'John Doe'</b>.
                                                </div>
                                            </div>
                                            <div class="note-statusbar">
                                                <div class="note-resizebar">
                                                    <div class="note-icon-bar"></div>
                                                    <div class="note-icon-bar"></div>
                                                    <div class="note-icon-bar"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group mb-0 col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                id="newsletter">
                                            <label class="custom-control-label" for="newsletter">Subscribe to
                                                newsletter</label>
                                            <div class="text-muted form-text">
                                                You will get new information about products, offers and promotions
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
