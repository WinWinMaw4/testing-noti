@extends("layouts.app")
@section("content")

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="text-center">
                    Show Route
                    <h4>Yor Got {{ $contacts->count() }} from {{ $from->email }}</h4>
                    <p>
                        {{ $sharedContact->message }}
                    </p>

                    <ul class="list-group">
                        @forelse($contacts as $contact)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="">
                                    <p class="fw-bold mb-0">
                                        {{ $contact->name }}
                                    </p>
                                    <p class="text-black-50 mb-0">
                                        {{ $contact->phone }}
                                    </p>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>

                    @if(auth()->id() === $sharedContact->from)
                        <div class="my-3">
                            <form action="{{route('shared-contact.update',$sharedContact->id)}}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="action" value="cancel">
                                <button class="btn btn-danger">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="my-3">
                            <form class="d-inline" action="{{route('shared-contact.update',$sharedContact->id)}}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="action" value="reject">
                                <button class="btn btn-outline-danger">
                                    Reject
                                </button>
                            </form>
                            <form class="d-inline" action="{{route('shared-contact.update',$sharedContact->id)}}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="action" value="accept">
                                <button class="btn btn-primary">
                                    Accept
                                </button>
                            </form>
                        </div>
                    @endif



                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Contact Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <label class="form-label" for="">Recipient Email</label>
                        <input type="text" name="email" form="bulk_action" class="form-control">
                    </div>
                    <div class="">
                        <label class="form-label" for="">Message</label>
                        <textarea name="message" form="bulk_action" class="form-control" id="" cols="30" rows="7"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="cancelAction()"  class="btn btn-secondary">Close</button>
                    <button type="submit" form="bulk_action" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Share
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push("js")
        <script>

            let emailModal = document.querySelector("#emailModal");
            let myEmailModal =new bootstrap.Modal(emailModal,{
                backdrop: "static"
            });

            let contactBulkFunctionalitySelect = document.querySelector(`[name="functionality"]`);
            contactBulkFunctionalitySelect.addEventListener("change",function (){
                let selected = Number(this.value);
                console.log(selected);

                if(selected === 1){
                    myEmailModal.show();
                }
            })

            function cancelAction(){
                contactBulkFunctionalitySelect.value = "";
                myEmailModal.hide();
            }
        </script>
    @endpush

@endsection


