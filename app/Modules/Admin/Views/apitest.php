<style>
    body {
      font-family: system-ui, sans-serif;
    }
    #result {
      margin-top: 24px;
      padding: 20px;
      border-radius: 8px;
      background: #f8f9fa;
      border: 1px solid #e0e0e0;
      min-height: 120px;
      white-space: pre-wrap;
      font-family: 'Consolas', 'Monaco', monospace;
    }
    .loading {
      color: #666;
      font-style: italic;
    }
    .error {
      background: #ffebee;
      border-color: #ef9a9a;
      color: #c62828;
    }
    button {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 src-100 p-2 mt-5">
            <h2>Test API Call with jQuery</h2>

            <p>Try one of these free public APIs:</p>
            <button id="btn-get">Get Link</button>
            <!-- <button id="btn-post">Post Link</button> -->
            <button id="btn-users">Get Random User</button>
            <button id="btn-joke">Get Random Joke</button>
            <button id="btn-todo">Get Todo #1</button>
            <button id="btn-ip">Get My IP</button>

            <div class="form-group my-3">
                <label for="link">link:</label>
                <input type="text" class="form-control" id="link_url" placeholder="Enter link" name="link">
            </div>
            <div id="result">Click a button to see result...</div>
        </div>
    </div>
</div>

  

<script>
    $(document).ready(function() {

      // Helper function to show result
      function showResult(data, type = 'success') {
        const $result = $('#result');
        
        if (type === 'loading') {
          $result.removeClass('error').addClass('loading')
                 .text('Loading...');
          return;
        }
        
        $result.removeClass('loading error');
        
        if (type === 'error') {
          $result.addClass('error')
                 .text('Error: ' + (data.message || data || 'Unknown error'));
          return;
        }

        // Success → try to show nicely formatted JSON
        let content = '';
        
        if (typeof data === 'object') {
          try {
            content = JSON.stringify(data, null, 2);
          } catch(e) {
            content = String(data);
          }
        } else {
          content = String(data);
        }

        $result.text(content);
      }

      // ─── Generic API caller ───
      function callApi(url) {
        showResult(null, 'loading');

        $.ajax({
          url: url,
          method: 'GET',
          timeout: 8000,
          success: function(data) {
            showResult(data, 'success');
          },
          error: function(xhr, status, error) {
            let msg = error;
            if (xhr.responseJSON && xhr.responseJSON.message) {
              msg = xhr.responseJSON.message;
            } else if (status === 'timeout') {
              msg = 'Request timed out (8s)';
            }
            showResult({message: msg}, 'error');
          }
        });
      }

      // Button handlers
      $('#btn-users').click(() => {
        $('#link_url').val('');
        callApi('https://randomuser.me/api/');
      });

      $('#btn-joke').click(() => {
         $('#link_url').val('');
        callApi('https://official-joke-api.appspot.com/random_joke');
      });

      $('#btn-todo').click(() => {
         $('#link_url').val('');
        callApi('https://jsonplaceholder.typicode.com/todos/1');
      });

      $('#btn-ip').click(() => {
         $('#link_url').val('');
        callApi('https://api.ipify.org?format=json');
      });

      $('#btn-get').click(() => {
            var link_url = $('#link_url').val();
            // console.log(link_url);
            if(link_url != ''){
                callApi(link_url);
            }
      });

      $('#link_url').on('keypress', function(e) {
        // Check if the key pressed is the Enter key (keyCode 13)
        if (e.which === 13) {
            var link_url = $(this).val();
            // console.log(link_url);
            if(link_url != ''){
                callApi(link_url);
            }
        }
    });

    });
</script>