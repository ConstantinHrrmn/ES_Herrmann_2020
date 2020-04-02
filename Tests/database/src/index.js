import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
  
  class Game extends React.Component {
    constructor(props) {
      super(props);
      this.state = {
        test : 100,
      };
    }

    getData(){
      let returnValue = "";
      fetch("http://myviewvision.ch/other/kggsmobile/program/all/index.php")
        .then(response => response.json())
        .then((jsonData) => {
          returnValue = "<div>";
          for(let i=0; i < jsonData.length; i++){
            var match = jsonData[i];
            console.log(match);
            returnValue += "<h1>"+match['IdMatch']+"</h1>";
          }
          returnValue += "</div>";
        })
        .catch((error) => {
          console.error(error)
        })

        return returnValue;
    }
  
    render() {
      return (
        <div className="game">
          <div className="game-board">
          </div>
          <div className="game-info">
            <div> Test connexion base de données </div>
            <h1>{this.state.test}</h1>
            <div>{this.getData()}</div>
          </div>
        </div>
      );
    }
  }
  
  ReactDOM.render(<Game />, document.getElementById("root"));